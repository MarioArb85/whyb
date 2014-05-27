<?php
  class Usuario {
    private $userId;
    private $rolId;
    private $countryId;
    private $nickname;
    private $password;
    private $email;
    private $blocked;
    private $name;
    private $birthdate;
    private $sex;
   
    function Usuario($userId, $rolId, $countryId, $nickname, $password, $email, $blocked, $name, $birthdate, $sex) {
      $this->userId = $userId;
      $this->rolId = $rolId;
      $this->countryId = $countryId;
      $this->nickname = $nickname;
      $this->password = $password;
      $this->email = $email;
      $this->blocked = $blocked;
      $this->name = $name;
      $this->birthdate = $birthdate;
      $this->sex = $sex;
    }

    function setUserId($userId) {
      $this->userId = $userId;
    }

    function getUserId() {
      return $this->userId;
    }

    function setRolId($rolId) {
      $this->rolId = $rolId;
    }

    function getRolId() {
      return $this->rolId;
    }

    function setCountryId($countryId) {
      $this->countryId = $countryId;
    }

    function getCountryId() {
      return $this->countryId;
    }  
    
    function setNickname($nickname) {
      $this->nickname = $nickname;
    }

    function getNickname() {
      return $this->nickname;
    }

    function setPassword($password) {
      $this->password = $password;
    }

    function getPassword() {
      return $this->password;
    }

    function setEmail($email) {
      $this->email = $email;
    }

    function getEmail() {
      return $this->email;
    }

    function setBlocked($blocked) {
    	$this->blocked = $blocked;
    }
    
    function getBlocked() {
    	return $this->blocked;
    }
    
    function setName($name) {
    	$this->name = $name;
    }
    
    function getName() {
    	return $this->name;
    }

    function setBirthdate($birthdate) {
      $this->birthdate = $birthdate;
    }
    
    function getBirthdate() {
      return $this->birthdate;
    }

    function setSex($sex) {
      $this->sex = $sex;
    }
    
    function getSex() {
      return $this->sex;
    }
  }
?>