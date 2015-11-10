<?php

namespace ExpressLibrary\Controllers;


use ExpressLibrary\Actions\Common\CommentAction;
use ExpressLibrary\Actions\Common\GetAllCommentsBySlugAction;
use ExpressLibrary\Actions\Common\GetAllDigitalBookCommentBySlugAction;
use ExpressLibrary\Actions\Common\GetDigitalBookByCategoryAction;
use ExpressLibrary\Actions\Common\GetDigitalBookBySlugAction;
use ExpressLibrary\Actions\Common\GetDigitalVoteCountAction;
use ExpressLibrary\Actions\Common\GetVoteCountAction;
use ExpressLibrary\Actions\User\GetUserDigitalVoteAction;
use ExpressLibrary\Actions\User\GetUserVoteAction;
use ExpressLibrary\Actions\User\GetRejectedBookRequestAction;
use ExpressLibrary\Actions\User\SignupAction;
use ExpressLibrary\Actions\User\VoteAction;
use ExpressLibrary\Actions\User\VoteDigitalBookAction;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use ExpressLibrary\Entities\User;
use ExpressLibrary\Forms\LoginType;
use ExpressLibrary\Forms\SignupType;
use Symfony\Component\HttpFoundation\Request;
use ExpressLibrary\Middlewares\AuthorizedMiddleware;
use ExpressLibrary\Actions\User\LoginAction;
use ExpressLibrary\Helpers\GetAllCategoriesHelper;
use ExpressLibrary\Actions\Common\GetFeaturedBooksAction;
use ExpressLibrary\Actions\Common\GetBookBySlugAction;
use ExpressLibrary\Actions\User\GetBooksByCategoryAction;
use ExpressLibrary\Actions\User\LogoutAction;
use ExpressLibrary\Actions\Common\GetUserProfileAction;
use ExpressLibrary\Actions\Common\EditUserProfileAction;
use ExpressLibrary\Entities\UserProfile;
use ExpressLibrary\Forms\UserProfileType;
use ExpressLibrary\Actions\User\BorrowBookAction;
use ExpressLibrary\Actions\User\GetBorrowRequestsAction;
use ExpressLibrary\Actions\User\DeleteBorrowRequestAction;
use ExpressLibrary\Actions\User\GetAllBorrowingBooksAction;
use ExpressLibrary\Actions\User\GetHistoryBookAction;



class Front extends BaseController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        /**
         * @var ControllerCollection $controllers
         */
        $controllers = $app['controllers_factory'];
       
        $controllers->get('/home', [$this, 'homeAction'])
            ->bind('homepage');

        $controllers->match('/user/login', [$this, 'userloginAction'])
            ->bind('userLogin');

        $controllers->match('/user/signup', [$this, 'signupAction'])
            ->bind('userSignup');

        $controllers->match('/user/profile', [$this, 'viewUserProfileAction'])
            ->bind('userProfile')->before([new AuthorizedMiddleware($app), 'authorize'])
            ->bind('userProfile');

        $controllers->get('/user/logout', [$this, 'logoutAction'])
            ->bind('userLogout')
            ->before([new AuthorizedMiddleware($app), 'authorize']);

        $controllers->get('/book/{slug}', [$this, 'viewBookBySlugAction'])
            ->bind('viewBookBySlug');

        $controllers->get('category/{slug}', [$this, 'viewBooksByCategoryAction'])
            ->bind('viewBooksByCategory');

        $controllers->match('/user/profile/edit', [$this, 'updateUserProfileAction'])
            ->bind('editUserProfile')->before([new AuthorizedMiddleware($app), 'authorize']);

        $controllers->post('/book/borrow', [$this, 'borrowBookAction'])
            ->bind('borrowBook')
            ->before([new AuthorizedMiddleware($app, "To borrow book, please login or sign up"), 'authorize']);

        $controllers->get('/book/request/view', [$this, 'viewMyBorrowRequestAction'])
            ->bind('viewBorrowRequest')
            ->before([new AuthorizedMiddleware($app), 'authorize']);

        $controllers->post('/book/request/delete', [$this, 'deleteMyBorrowRequestAction'])
            ->bind('deleteBorrowRequest')->before([new AuthorizedMiddleware($app), 'authorize']);

        $controllers->get('/book/request/borrowing', [$this, 'viewBorrowingBooksAction'])
            ->bind('viewBorrowingBooks')->before([new AuthorizedMiddleware($app), 'authorize']);

        $controllers->get('/book/history/history', [$this, 'viewHistoryBookAction'])
            ->bind('viewHistory')->before([new AuthorizedMiddleware($app), 'authorize']);

        $controllers->get('/book/request/rejected', [$this, 'viewRejectedRequestAction'])
            ->bind('viewRejectedRequest')->before([new AuthorizedMiddleware($app), 'authorize']);

        $controllers->post('/book/vote/vote', [$this, 'getVoteAction'])
            ->bind('vote')->before([new AuthorizedMiddleware($app, "To Vote please login first"), 'authorize']);

        $controllers->post('/book/comment/{slug}', [$this, 'commentAction'])
            ->bind('commenting')->before([new AuthorizedMiddleware($app, "To Comment, please login first"), 'authorize']);

        $controllers->get('/digital-book/category/{slug}', [$this, 'getDigitalBookByCategoryAction'])
            ->bind('getDigitalBookByCategory');

        $controllers->get('/digital-book/{slug}', [$this, 'viewDigitalBookBySlugAction'])
            ->bind('getDigitalBookBySlug');

        $controllers->post('/digital-book/vote', [$this, 'voteDigitalBookAction'])
            ->bind('voteDigitalBook');

        return $controllers;
    }

    public function homeAction(Request $request)
    {
        $action = new GetFeaturedBooksAction($this->app);

        $page = (int) $request->query->get('page', 1);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5 /* per page limit */
        );

        $categories = GetAllCategoriesHelper::help(1);

        return $this->app['twig']->render('home.twig',
            [
                'categories' => $categories,
                'pagination' => $pagination
            ]
        );

    }

    public function userloginAction(Request $request) 
    {   

        $user = new User();
        $loginAction = new LoginAction($this->app);

        $categories = GetAllCategoriesHelper::help(1);

        $form = $this->app['form.factory']->create(new LoginType, $user);


        if($request->getMethod() == "POST") {

            $form->handleRequest($request);


            if($form->isValid()) {

               $login = $loginAction->handle($user);

               if($login) {

                   return $this->app->redirect($this->app["url_generator"]->generate("userProfile"));

               } else {

                   $this->app['session']->getFlashBag()
                       ->add('message',
                           'Invalid login credential or your account is not active'
                       );

                   return $this->app['twig']->render('login.twig',
                       [
                           'form' => $form->createView(),
                           'categories' => $categories
                       ]
                   );
               }

            } else {

                return $this->app['twig']->render('login.twig',
                    [
                        'form' => $form->createView(),
                        'categories' => $categories
                    ]
                );
            }
        } else {

                return $this->app['twig']->render('login.twig',
                    [
                        'form' => $form->createView(),
                        'categories' => $categories
                    ]
                );
        }
    }

    public function signupAction(Request $request) 
    {
        $user = new User();

        $signup = new SignupAction($this->app);

        $categories = GetAllCategoriesHelper::help(1);

        $form = $this->app['form.factory']->create(new SignupType, $user);

        if($request->getMethod() == "POST") {

            $form->handleRequest($request);

            if($form->isValid()) {

               $signup->handle($user);

                return $this->app['twig']->render('success.html',
                    [
                        'categories' => $categories
                    ]
                );
            
            } else {

                return $this->app['twig']->render('signup.html',
                    [
                        'form' => $form->createView(),
                        'categories' => $categories
                    ]
                );

            } 
        } else {

                return $this->app['twig']->render('signup.html',
                    [
                        'form' => $form->createView(),
                        'categories' => $categories
                    ]
                );
        }

        
    }

    public function profileAction(Request $request)
    {
        $categories = GetAllCategoriesHelper::help(1);

        return $this->app['twig']->render('userProfile.twig',
            [
                'categories' => $categories
            ]
        );
    }

    public function logoutAction()
    {
        $action = new LogoutAction($this->app);

        $action->handle();

        $this->app['session']->getFlashBag()
            ->add('message', 'You are logged out now');

        return $this->app->redirect($this->app["url_generator"]->generate("userLogin"));

    }

    public function viewBookBySlugAction(Request $request, $slug)
    {
        $page = $request->query->get('page', 1);

        $action = new GetBookBySlugAction($this->app);

        $getComments = new GetAllCommentsBySlugAction($this->app);

        $data = $action->handle($slug);

        $getVote = new GetUserVoteAction($this->app);

        $getCountVote = new GetVoteCountAction($this->app);

        $countData = $getCountVote->handle($data['id']);

        $vote = $getVote->handle($data['id']);

        $categories = GetAllCategoriesHelper::help(1);

        $comments = $getComments->handle($data['id']);

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $comments,
            $page,
            5
        );

        return $this->app['twig']->render('viewBookBySlug.twig',
            [
                'data' => $data,
                'categories' => $categories,
                'vote' => $vote,
                'countData' => $countData,
                'pagination' => $pagination
            ]
        );
    }

    public function viewBooksByCategoryAction(Request $request, $slug)
    {
        $page = (int) $request->query->get('page', 1);

        $action = new GetBooksByCategoryAction($this->app);

        $categories = GetAllCategoriesHelper::help(1);



        $qb = $action->handle($slug);


        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        return $this->app['twig']->render('viewBooksByCategory.twig',
            [
                'pagination' => $pagination,
                'categories' => $categories
            ]
        );
    }

    public function viewUserProfileAction(Request $request)
    {
        $categories = GetAllCategoriesHelper::help(1);

        $action = new GetUserProfileAction($this->app);

        $userProfile = $action->handle();

        $session = $this->app['session'];

        if (!$userProfile) {

            $session->getFlashBag()->add('message',
                'You dont have profile yet, please create by clicking button Profile'
            );

            return $this->app['twig']->render('userProfile.twig',
                [
                    'profile' => $userProfile,
                    'categories' => $categories
                ]
            );

        } else {

            return $this->app['twig']->render('userProfile.twig',
                [
                    'categories' => $categories,
                    'profile' => $userProfile
                ]
            );
        }
    }

    public function updateUserProfileAction(Request $request)
    {
        $profile = new UserProfile();

        $categories = GetAllCategoriesHelper::help(1);

        $action = new EditUserProfileAction($this->app);

        $form = $this->app['form.factory']->create(new UserProfileType(), $profile);

        if ($request->getMethod() == "POST") {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $action->handle($profile);
                return $this->app->redirect($this->app["url_generator"]->generate("userProfile"));

                //return "valid";
                //return print_r($profile);

            } else {
                return $this->app['twig']->render('editUserProfile.twig',
                    [
                        'form' => $form->createView(),
                        'categories' => $categories
                    ]
                );
            }

            //return print_r($profile);
            //return $this->app->redirect($this->app["url_generator"]->generate("userProfile"));

        } else {

            return $this->app['twig']->render('editUserProfile.twig',
                [
                    'form' => $form->createView(),
                    'categories' => $categories
                ]
            );
        }


    }

    public function borrowBookAction(Request $request)
    {
        $action = new BorrowBookAction($this->app);

        $session = $this->app['session'];

        $request = $this->app['request'];

        $slug = $request->request->get('slug');

        $action->handle($slug);

        $session->getFlashBag()->add('message', 'This book has added to request list');

        return $this->app->redirect($this->app["url_generator"]->generate("viewBookBySlug",
            [
                'slug' => $slug
            ]
        ));

    }

    public function viewMyBorrowRequestAction(Request $request)
    {

        $categories = GetAllCategoriesHelper::help(1);

        $action = new GetBorrowRequestsAction($this->app);

        $datas = $action->handle();

        return $this->app['twig']->render('viewMyBorrowRequest.twig',
            [
                'datas' => $datas,
                'categories' => $categories
            ]
        );
    }

    public function deleteMyBorrowRequestAction(Request $request)
    {
        $action = new DeleteBorrowRequestAction($this->app);

        $request = $this->app['request'];

        $bookId = $request->request->get('bookId');

        $action->handle($bookId);

        return $this->app->redirect($this->app["url_generator"]->generate("viewBorrowRequest"));
    }

    public function viewBorrowingBooksAction(Request $request)
    {
        $categories = GetAllCategoriesHelper::help(1);

        $action = new GetAllBorrowingBooksAction($this->app);

        $datas = $action->handle();

        return $this->app['twig']->render('viewBorrowingBooks.twig',
            [
                'datas' => $datas,
                'categories' => $categories

            ]
        );
    }

    public function viewHistoryBookAction(Request $request)
    {
        $categories = GetAllCategoriesHelper::help(1);

        $page = (int) $request->query->get('page', 1);

        $action = new GetHistoryBookAction($this->app);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        return $this->app['twig']->render('viewHistoryBook.twig',
            [
                'pagination' => $pagination,
                'categories' => $categories
            ]
        );


    }

    public function viewRejectedRequestAction(Request $request)
    {
        $action = new GetRejectedBookRequestAction($this->app);

        $categories = GetAllCategoriesHelper::help(1);

        $page = (int) $request->query->get('page', 1);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        return $this->app['twig']->render('viewRejectedBookRequest.twig',
            [
                'pagination' => $pagination,
                'categories' => $categories
            ]
        );
    }

    public function getVoteAction(Request $request)
    {
        $slug = $request->request->get('bookSlug');
        $voteResult = $request->request->get('voteResult');

        $action = new VoteAction($this->app);

        $action->handle($slug, $voteResult);

        return $this->app->redirect($request->headers->get('referer'));
    }

    public function commentAction(Request $request, $slug)
    {
        $getAction = new GetBookBySlugAction($this->app);

        $commentAction = new CommentAction($this->app);

        $comments = $request->request->get('comments');

        $data = $getAction->handle($slug);

        $commentAction->handle($comments, $data['id']);

        return $this->app->redirect($request->headers->get('referer'));
    }

    public function viewDigitalBookBySlugAction(Request $request, $slug)
    {

        $page = (int) $request->query->get('page', 1);

        $action = new GetDigitalBookBySlugAction($this->app);

        $getComment = new GetAllDigitalBookCommentBySlugAction($this->app);

        $getVote = new GetUserDigitalVoteAction($this->app);

        $getCountVote = new GetDigitalVoteCountAction($this->app);

        $data = $action->handle($slug);

        $vote = $getVote->handle($data['id']);

        $qb = $getComment->handle($data['id']);

        $countData = $getCountVote->handle($data['id']);

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );


        return $this->app['twig']->render('viewDigitalBookBySlug.twig',
            [
                'data' => $data,
                'categories' => GetAllCategoriesHelper::help(1),
                'vote' => $vote,
                'countData' => $countData,
                'pagination' => $pagination

            ]
        );
    }

    public function getDigitalBookByCategoryAction(Request $request, $slug)
    {
        $page = (int) $request->query->get('page', 1);

        $action = new GetDigitalBookByCategoryAction($this->app);

        $categories = GetAllCategoriesHelper::help(1);

        $qb = $action->handle($slug);


        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        return $this->app['twig']->render('getDigitalBookByCategory.twig',
            [
                'pagination' => $pagination,
                'categories' => $categories
            ]
        );


    }

    public function voteDigitalBookAction(Request $request)
    {
        $action = new VoteDigitalBookAction($this->app);

        $action->handle();

        return $this->app->redirect($request->headers->get('referer'));
    }

}
