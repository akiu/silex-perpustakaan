<?php

namespace ExpressLibrary\Entities;

class UserProfile
{
    protected $userId;
    protected $namaDepan;
    protected $namaBelakang;
    protected $ttl;
    protected $alamat;
    protected $jenisIdentitas;
    protected $noIdentitas;
    protected $profilePicture;
    protected $profilePicturePath;

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getNamaDepan()
    {
        return $this->namaDepan;
    }

    public function setNamaDepan($namaDep)
    {
        $this->namaDepan = $namaDep;
    }

    public function getNamaBelakang()
    {
        return $this->namaBelakang;
    }

    public function setNamaBelakang($namaBel)
    {
        $this->namaBelakang = $namaBel;
    }

    public function getTtl()
    {
        return $this->ttl;
    }

    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
    }

    public function getAlamat()
    {
        return $this->alamat;
    }

    public function setAlamat($alamat)
    {
        $this->alamat = $alamat;
    }

    public function getJenisIdentitas()
    {
        return $this->jenisIdentitas;
    }

    public function setJenisIdentitas($jedas)
    {
        $this->jenisIdentitas = $jedas;
    }

    public function getNoIdentitas()
    {
        return $this->noIdentitas;
    }

    public function setNoIdentitas($noiden)
    {
        $this->noIdentitas = $noiden;
    }

    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function setProfilePicture($propic)
    {
        $this->profilePicture = $propic;
    }

    public function getProfilePicturePath()
    {
        return $this->profilePicturePath;
    }

    public function setProfilePicturePath($propicpath)
    {
        $this->profilePicturePath = $propicpath;
    }
}