<?php

namespace ExpressLibrary\Controllers;


use ExpressLibrary\Actions\Admin\AddAdminAction;
use ExpressLibrary\Actions\Admin\AddFeaturedBookAction;
use ExpressLibrary\Actions\Admin\EditBookBySlugAction;
use ExpressLibrary\Actions\Admin\EditCategoryAction;
use ExpressLibrary\Actions\Admin\EditDigitalBookAction;
use ExpressLibrary\Actions\Admin\GetBannedUserAction;
use ExpressLibrary\Actions\Admin\GetPendingUserAction;
use ExpressLibrary\Actions\Common\GetDigitalBookByCategoryAction;
use ExpressLibrary\Actions\Common\GetDigitalBookBySlugAction;
use ExpressLibrary\Forms\AddAdminType;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use ExpressLibrary\Entities\Category;
use ExpressLibrary\Forms\CategoryForm;
use ExpressLibrary\Actions\Admin\AddCategoryAction;
use ExpressLibrary\Actions\Admin\RetrieveCategoryAction;
use ExpressLibrary\Actions\Admin\DeleteCategoryAction;
use ExpressLibrary\Forms\BookForm;
use ExpressLibrary\Entities\Book;
use ExpressLibrary\Actions\Admin\AddBookAction;
use ExpressLibrary\Entities\DigitalBook;
use ExpressLibrary\Actions\Admin\AddDigitalBookAction;
use ExpressLibrary\Forms\DigitalBookForm;
use ExpressLibrary\Forms\AdminLoginType;
use ExpressLibrary\Entities\Admin;
use ExpressLibrary\Actions\Admin\AdminLoginAction;
use ExpressLibrary\Actions\Admin\AdminLogoutAction;
use ExpressLibrary\Middlewares\AdminAuthorizationMiddleware;
use ExpressLibrary\Actions\Admin\BrowseBookByCategoryAction;
use ExpressLibrary\Helpers\GetAllCategoriesHelper;
use ExpressLibrary\Actions\Common\GetBookBySlugAction;
use ExpressLibrary\Actions\Admin\DeleteBookBySlugAction;
use ExpressLibrary\Actions\Admin\GetAllCategoriesAction;
use ExpressLibrary\Actions\Common\GetFeaturedBooksAction;
use ExpressLibrary\Actions\Admin\RemoveFeaturedBookAction;
use ExpressLibrary\Actions\Admin\GetAllBorrowRequestsAction;
use ExpressLibrary\Helpers\GetBorrowRequestCountHelper;
use ExpressLibrary\Actions\Admin\ApproveBorrowRequestAction;
use ExpressLibrary\Actions\Admin\GetAllBorrowingAction;
use ExpressLibrary\Actions\Admin\GetAllUserAction;
use ExpressLibrary\Actions\Admin\GetUserProfileAction;
use ExpressLibrary\Helpers\GetCountOfBookInBorrowingHelper;
use ExpressLibrary\Actions\Admin\ReturnBorrowingBookAction;
use ExpressLibrary\Actions\Admin\ActivateUserAction;
use ExpressLibrary\Actions\Admin\BlockUserAction;
use ExpressLibrary\Actions\Admin\GenerateLateBookAction;
use ExpressLibrary\Actions\Admin\GetLateBooksAction;
use ExpressLibrary\Actions\Admin\GetAllAdminAction;
use ExpressLibrary\Actions\Admin\GetBooksRequestByUserNameAction;
use ExpressLibrary\Actions\Admin\RejectBorrowRequestAction;

class Back extends BaseController implements ControllerProviderInterface
{
    /**
     * @param Application $app
     * @return ControllerCollection
     */
    public function connect(Application $app)
    {
        /**
         * @var ControllerCollection $controllers
         */
        $controllers = $app['controllers_factory'];

       
        $controllers->match('/login', [$this, 'loginAction'])->bind("adminlogin");
        $controllers->match('/home', [$this, 'dashboardAction'])->bind("adminHome")->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->match('/add', [$this, 'addproductAction'])->bind('addProduct')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->match("/addcat", [$this, 'addcategoryAction'])->bind('addCategory')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->post('/deletecat/{slug}', [$this, 'deletecategoryAction'])->bind('deleteCategory')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->match('/editcat/{slug}', [$this, 'editcategoryAction'])->bind('editCategory')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->match('/addbook', [$this, 'addbookAction'])->bind('addBook')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->match('/adddigitalbook', [$this, 'addDigBookAction'])->bind('addDigBook')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/book/category/{category}', [$this, 'browseBookByCategoryAction'])->bind('browseByCategory')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/book', [$this, 'browseBookAction'])->bind('browseBook')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/book/slug/{slug}', [$this, 'browseBookBySlugAction'])->bind('browseBySlug')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->post('/book/slug/{slug}', [$this, 'deleteBookBySlugAction'])->bind('deleteBySlug')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->post('/add-featured-book', [$this, 'addFeaturedBookAction'])->bind('addFeaturedBook')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/book/featured-book', [$this, 'viewFeaturedBooksAction'])->bind('viewFeaturedBooks')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->post('/book/delete-featured-book', [$this, 'deleteFeaturedBookAction'])->bind('deleteFeaturedBook')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->match('/book/edit', [$this, 'editBookBySlugAction'])->bind('editBookBySlug')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/book/request', [$this, 'viewAllBorrowRequestAction'])->bind('viewAllBorrowRequest')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->post('/book/request/approve', [$this, 'approveUserBorrowRequest'])->bind('approveBorrowRequest')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/book/borrowing', [$this, 'viewAllBorrowingAction'])->bind('viewAllBorrowing')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/user/viewall', [$this, 'viewAllUsersAction'])->bind('viewAllUsers')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/user/profile/{id}', [$this, 'viewUserProfileAction'])->bind('viewUserProfile')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->post('/book/return-book', [$this, 'returnBookAction'])->bind('returnBook')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->post('book/user/activate', [$this, 'activateUserAction'])->bind('activateUser')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->post('/book/user/ban', [$this, 'banUserAction'])->bind('banUser')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/book/late-book', [$this, 'viewLateBookAction'])->bind('getLateBooks')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->post('/book/late-book', [$this, 'generateLateBookAction'])->bind('generateLateBooks')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->match('/admin/view-all', [$this, 'viewAllAdminsAction'])->bind('viewAllAdmin')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/dashboard', [$this, 'viewAdminDashboardAction'])->bind('adminDashboard')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->post('/logout', [$this, 'adminLogoutAction'])->bind('adminLogout')->before([new AdminAuthorizationMiddleware($app), 'authorize']);
        $controllers->get('/book/request/search', [$this, 'searchBooksRequestByUserNameAction'])->bind('searchRequestByUserName');
        $controllers->post('/book/request/reject', [$this, 'rejectUserBorrowRequest'])->bind('rejectBorrowRequest');
        $controllers->match('/book/edit/{slug}', [$this, 'editBookBySlugAction'])
            ->bind('editBookBySlug');

        $controllers->get('/user/pending', [$this, 'viewPendingUserAction'])
            ->bind('getPendingUser');

        $controllers->get('/user/banned', [$this, 'viewBannedUserAction'])
            ->bind('getBannedUser');

        $controllers->get('/digital-book/{slug}', [$this, 'viewDigitalBookBySlugAction'])
            ->bind('viewDigitalBookBySlug');

        $controllers->get('/digital-book/{category}', [$this, 'viewDigitalBooksByCategoryAction'])
            ->bind('viewDigitalBooksByCategory');

        $controllers->get('/digital-book', [$this, 'viewDigitalBooksCategoryAction'])
            ->bind('viewDigitalBooksCategory');

        $controllers->get('/digital-book/slug/{slug}', [$this, 'viewDigitalBookBySlugAction'])
            ->bind('viewDigitalBookBySlug');

        $controllers->match('/digital-book/edit/{slug}', [$this, 'editDigitalBookBySlugAction'])
            ->bind('editDigitalBookBySlug');

        $controllers->match('/admin/add-admin', [$this, 'addAdminAction'])
            ->bind('addAdmin');


        return $controllers;
    }

    public function indexAction(Request $request)
    {
        return 'hello from admin';
    }

    public function loginAction(Request $request)
    {
        $loggedAdmin = new Admin();

        $action = new AdminLoginAction($this->app);

        $form = $this->app['form.factory']->create(new AdminLoginType(), $loggedAdmin);

        if ( $request->getMethod() == "POST" )
        {
            $form->handleRequest($request);

            if( $form->isValid() )
            {
                $check = $action->handle($loggedAdmin);

                if ($check) {

                    return $this->app->redirect($this->app["url_generator"]->generate("adminDashboard"));

                } else {

                    return $this->app->redirect($this->app["url_generator"]->generate("adminlogin"));


                }
            }

        }

        return $this->app['twig']->render('admin/login.twig', ['form' => $form->createView()]);
    }

    public function dashboardAction()
    {
        return $this->app['twig']->render('admin/home.twig');
    }


    public function addProductAction()
    {
        return $this->app['twig']->render('admin/addProduct.twig');
    }

    public function addcategoryAction(Request $request)
    {
        $reqCountAction = new GetAllBorrowRequestsAction($this->app);

        $category = new Category();

        $action = new AddcategoryAction($this->app);

        $retrieveAction = new  RetrieveCategoryAction($this->app);


        $form = $this->app['form.factory']->create(new CategoryForm(), $category);

        if($request->getMethod() == "POST")
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $action->handle($category);
                $categories = $retrieveAction->handle();

                return $this->app['twig']->render(
                    'admin/addCategory.twig',
                    [
                        'form' => $form->createView(),
                        'categories' => $categories,
                        'value' => 'Add category',
                        'requestCount' => GetBorrowRequestCountHelper::help(),
                        'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()

                    ]
                );

            }
        }
        $categories = $retrieveAction->handle();

        return $this->app['twig']->render(
            'admin/addCategory.twig',
            [
                'form' => $form->createView(),
                'categories' => $categories,
                'value' => 'Add category',
                'requestCount' =>  GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()

            ]
        );
    }

    public function deleteCategoryAction(Request $request, $slug)
    {
        $deleteAction = new DeleteCategoryAction($this->app);

        $deleteAction->handle($slug);

        return $this->app->redirect($this->app["url_generator"]->generate("addCategory"));

    }

    public function editcategoryAction(Request $request, $slug)
    {

        $category = new Category();

        $retrieveAction = new RetrieveCategoryAction($this->app);
        $editAction = new EditCategoryAction($this->app);

        $data = $retrieveAction->handle($slug);

        $form = $this->app['form.factory']->create(new CategoryForm(), $category);

        if ($request->getMethod() == "POST")
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $editAction->handle($category, $data[0]);
                return $this->app->redirect($this->app["url_generator"]->generate("addCategory"));

            }
        }

        return $this->app['twig']->render(
            'admin/editCategory.twig',
            [
                'form' => $form->createView(),
                'slug' => $data[2],
                'nama' => $data[1],
                'value' => "Edit category",
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()


            ]
            );
    }

    public function addBookAction(Request $request)
    {
        $book = new Book();

        $action = new AddBookAction($this->app);

        $form = $this->app['form.factory']->create(new BookForm(), $book);

        if ( $request->getMethod() == "POST" )
        {

            $form->handleRequest($request);

            if ( $form->isValid() )
            {

                $action->handle($book);
                return $this->app->redirect($this->app["url_generator"]->generate("addBook"));

            }
            else
            {
                return $this->app['twig']->render('admin/addBook.twig',
                    [
                        'form' => $form->createView(),
                        'requestCount' => GetBorrowRequestCountHelper::help(),
                        'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()


                    ]
                );
            }
        }

        return $this->app['twig']->render('admin/addBook.twig',
            [
                'form' => $form->createView(),
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()


            ]
        );
    }

    public function addDigBookAction(Request $request)
    {
        $digiBook = new DigitalBook();

        $action = new AddDigitalBookAction($this->app);

        $form = $this->app['form.factory']->create(new DigitalBookForm(), $digiBook);

        if ( $request->getMethod() == "POST" )
        {
            $form->handleRequest($request);

            if ( $form->isValid() )
            {
                $action->handle($digiBook);
                return $this->app->redirect($this->app["url_generator"]->generate("addDigBook"));
            }
            else
            {
                return $this->app['twig']->render('admin/addDigBook.twig',
                    [
                        'form' => $form->createView(),
                        'requestCount' => GetBorrowRequestCountHelper::help(),
                        'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()


                    ]
                );
            }
        }

        return $this->app['twig']->render('admin/addDigBook.twig',
            [
                'form' => $form->createView(),
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()


            ]
        );
    }

    public function browseBookByCategoryAction(Request $request, $category)
    {
        $action = new BrowseBookByCategoryAction($this->app);

        $categories = GetAllCategoriesHelper::help(1);

        $datas = $action->handle($category);

        return $this->app['twig']->render('admin/browseByCategory.twig',
            [
                'datas' => $datas,
                'category' => $category,
                'categories' => $categories,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()


            ]
        );
    }

    public function browseBookAction(Request $request)
    {
        $action = new GetAllCategoriesAction($this->app);

        $page = (int) $request->query->get('page', 1);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        return $this->app['twig']->render('admin/browseBook.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()


            ]
        );
    }


    public function browseBookBySlugAction(Request $request, $slug)
    {
        $action = new GetBookBySlugAction($this->app);

        $data = $action->handle($slug);

        return $this->app['twig']->render('admin/browseBookBySlug.twig',
            [
                'data' => $data,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()
            ]
        );
    }

    public function deleteBookBySlugAction(Request $request, $slug)
    {
        $action = new DeleteBookBySlugAction($this->app);

        $action->handle($slug);

        return $this->app->redirect($request->headers->get('referer'));
    }

    public function addFeaturedBookAction(Request $request)
    {
        $slug = $request->request->get('slug');

        $action = new AddFeaturedBookAction($this->app);

        $action->handle($slug);

        return $this->app->redirect($this->app["url_generator"]->generate("addCategory"));
    }

    public function viewFeaturedBooksAction(Request $request)
    {
        $action = new GetFeaturedBooksAction($this->app);

        $page = (int) $request->query->get('page', 1);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        return $this->app['twig']->render('admin/viewFeaturedBooks.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()


            ]
        );
    }

    public function deleteFeaturedBookAction(Request $request)
    {

        $slug = $request->request->get('slug');

        $action = new RemoveFeaturedBookAction($this->app);

        $action->handle($slug);

        return $this->app->redirect($this->app["url_generator"]->generate("viewFeaturedBooks"));

    }

    public function editBookBySlugAction(Request $request, $slug)
    {
        $getAction = new GetBookBySlugAction($this->app);
        $editAction = new EditBookBySlugAction($this->app);

        $data = $getAction->handle($slug);

        if ($request->getMethod() == "POST")
        {

            $bookTitle = $request->request->get('bookTitle');
            $bookCategory = $request->request->get('bookCategory');
            $bookAuthor = $request->request->get('bookAuthor');
            $bookDescription = $request->request->get('bookDescription');
            $bookImage = $request->files->get('imageBook');
            $totalPage = $request->request->get('totalPage');

            $editAction->handle(
                $data['id'],
                $data['imagePath'],
                $bookTitle,
                $bookCategory,
                $bookAuthor,
                $bookDescription,
                $totalPage,
                $bookImage
            );

            return $this->app->redirect($request->headers->get("referer"));
        }

        return $this->app['twig']->render('admin/editBookBySlug.twig',
            [
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help(),
                'data' => $data,
                'categories' => GetAllCategoriesHelper::help(2)
            ]
        );
    }

    public function viewAllBorrowRequestAction(Request $request)
    {
        $page = (int) $request->query->get('page', 1);

        $action = new GetAllBorrowRequestsAction($this->app);

        $datas = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $datas,
            $page,
            5
        );

        return $this->app['twig']->render('admin/viewAllBooksRequests.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()

            ]
        );


    }

    public function approveUserBorrowRequest(Request $request)
    {

        $action = new ApproveBorrowRequestAction($this->app);

        $requestId = $request->request->get('requestId');
        $numOfDays = $request->request->get('numOfDays');
        $numOfBook = $request->request->get('numOfBook');

        $action->handle($requestId, $numOfDays, $numOfBook);

        return $this->app->redirect($request->headers->get('referer'));

    }

    public function rejectUserBorrowRequest(Request $request)
    {
        $requestId = $request->request->get('requestId');

        $action = new RejectBorrowRequestAction($this->app);

        $action->handle($requestId);

        return $this->app->redirect($request->headers->get('referer'));

    }

    public function viewAllBorrowingAction(Request $request)
    {
        $page = (int) $request->query->get('page', 1);

        $action = new GetAllBorrowingAction($this->app);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            10
        );

        return $this->app['twig']->render('admin/viewAllBorrowing.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()

            ]
        );
    }

    public function viewAllUsersAction(Request $request)
    {
        $page = (int) $request->query->get('page', 1);

        $action = new GetAllUserAction($this->app);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            10
        );

        return $this->app['twig']->render('admin/viewAllUsers.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()

            ]
        );
    }

    public function viewUserProfileAction(Request $request, $id)
    {
        $action = new GetUserProfileAction($this->app);

        $data = $action->handle($id);

        return $this->app['twig']->render('admin/viewUserProfile.twig',
            [
                'data' => $data,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()
            ]
        );
    }

    public function returnBookAction(Request $request)
    {
        $userId = $request->request->get('userId');
        $bookId = $request->request->get('bookId');

        $action = new ReturnBorrowingBookAction($this->app);

        $action->handle($userId, $bookId);

        return $this->app->redirect($this->app["url_generator"]->generate("viewAllBorrowing"));
    }

    public function activateUserAction(Request $request)
    {
        $userId = $request->request->get('userId');

        $action = new ActivateUserAction($this->app);

        $action->handle($userId);

        return $this->app->redirect($this->app["url_generator"]->generate("viewAllUsers"));


    }

    public function banUserAction(Request $request)
    {
        $userId = $request->request->get('userId');

        $action = new BlockUserAction($this->app);

        $action->handle($userId);

        return $this->app->redirect($this->app["url_generator"]->generate("viewAllUsers"));
    }

    public function viewLateBookAction(Request $request)
    {
        $page = (int) $request->query->get('page', 1);

        $action = new GetLateBooksAction($this->app);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        return $this->app['twig']->render('admin/viewAllLateBooks.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()

            ]
        );
    }

    public function generateLateBookAction()
    {
        $action = new GenerateLateBookAction($this->app);

        $action->handle();

        return $this->app->redirect($this->app["url_generator"]->generate("getLateBooks"));

    }

    public function viewAllAdminsAction(Request $request)
    {
        $page = (int) $request->query->get('page', 1);

        $addAction = new AddAdminAction($this->app);

        $admin = new Admin();

        $form = $this->app['form.factory']->create(new AddAdminType(), $admin);

        $action = new GetAllAdminAction($this->app);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        if ($request->getMethod() == "POST")
        {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $addAction->handle($admin);
                return $this->app->redirect($this->app['url_generator']->generate("viewAllAdmin"));

            } else {

                return $this->app['twig']->render('admin/viewAllAdmin.twig',
                    [
                        'pagination' => $pagination,
                        'requestCount' => GetBorrowRequestCountHelper::help(),
                        'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help(),
                        'form' => $form->createView()

                    ]
                );
            }
        }

        return $this->app['twig']->render('admin/viewAllAdmin.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help(),
                'form' => $form->createView()

            ]
        );
    }

    public function viewAdminDashboardAction(Request $request)
    {
        return $this->app['twig']->render('admin/adminDashboard.twig',
            [
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()
            ]
        );
    }

    public function adminLogoutAction(Request $request)
    {
        $action = new AdminLogoutAction($this->app);

        $action->handle();

        return $this->app->redirect($this->app["url_generator"]->generate("adminlogin"));
    }

    public function searchBooksRequestByUserNameAction(Request $request)
    {
        $userName = $request->query->get('query');

        $page = (int) $request->query->get('page', 1);

        $action = new GetBooksRequestByUserNameAction($this->app);

        $qb = $action->handle($userName);

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        return $this->app['twig']->render('admin/viewAllBooksRequests.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()

            ]
        );
    }

    public function viewPendingUserAction(Request $request)
    {
        $page = (int) $request->query->get('page', 1);

        $action = new GetPendingUserAction($this->app);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        return $this->app['twig']->render('admin/viewAllUsers.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()
            ]
        );
    }

    public function viewBannedUserAction(Request $request)
    {
        $page = (int) $request->query->get('page', 1);

        $action = new GetBannedUserAction($this->app);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            5
        );

        return $this->app['twig']->render('admin/viewAllUsers.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()
            ]
        );
    }

    public function viewDigitalBooksCategoryAction(Request $request)
    {
        $page = (int) $request->query->get('page', 1);

        $action = new GetAllCategoriesAction($this->app);

        $qb = $action->handle();

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            10
        );

        return $this->app['twig']->render('admin/browseDigitalBooks.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()
            ]
        );
    }

    public function viewDigitalBooksByCategoryAction(Request $request, $category)
    {
        $page = (int) $request->query->get('page', 1);

        $action = new GetDigitalBookByCategoryAction($this->app);

        $qb = $action->handle($category);

        $pagination = $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            $page,
            10
        );

        return $this->app['twig']->render('admin/viewDigitalBooksByCategory.twig',
            [
                'pagination' => $pagination,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help(),
                'categories' => GetAllCategoriesHelper::help(1),
                'category' => $category
            ]
        );
    }

    public function viewDigitalBookBySlugAction(Request $request, $slug)
    {
        $action = new GetDigitalBookBySlugAction($this->app);

        $data = $action->handle($slug);

        return $this->app['twig']->render('admin/viewDigitalBookBySlug.twig',
            [
                'data' => $data,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help()
            ]
        );
    }

    public function editDigitalBookBySlugAction(Request $request, $slug)
    {
        $getAction = new GetDigitalBookBySlugAction($this->app);
        $editAction = new EditDigitalBookAction($this->app);

        $data = $getAction->handle($slug);

        if ($request->getMethod() == "POST" ) {

            $bookTitle = $request->request->get('bookTitle');
            $bookCategory = $request->request->get('bookCategory');
            $bookAuthor = $request->request->get('bookAuthor');
            $bookDescription = $request->request->get('bookDescription');
            $bookImage = $request->files->get('bookImage');
            $bookAttachment = $request->files->get('bookAttachment');
            $totalPage = $request->request->get('totalPage');

            $editAction->handle(
                $data['id'],
                $bookImage,
                $bookAttachment,
                $bookTitle,
                $bookCategory,
                $bookAuthor,
                $totalPage,
                $bookDescription,
                $data['imagePath'],
                $data['attachmentPath']
            );

            return $this->app->redirect($request->headers->get('referer'));
        }

        return $this->app['twig']->render('admin/editDigitalBookBySlug.twig',
            [
                'data' => $data,
                'requestCount' => GetBorrowRequestCountHelper::help(),
                'countOfBorrowing' => GetCountOfBookInBorrowingHelper::help(),
                'categories' => GetAllCategoriesHelper::help(2)
            ]
        );
    }

    public function addAdminAction(Request $request)
    {

        $admin = new Admin();

        $form = $this->app['form.factory']->create(new AddAdminType(), $admin);

        if ($request->getMethod() == "POST")
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $action->handle($admin);

            } else

            {
                return $this->app['twig']->render('admin/addAdmin.twig',
                    [
                        'form' => $form->createView()
                    ]
                );
            }
        }

        return $this->app['twig']->render('admin/addAdmin.twig',
            [
                'form' => $form->createView()
            ]
        );
    }







}
