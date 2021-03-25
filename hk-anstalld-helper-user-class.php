<?php
class HKUser {
  /* Properties */
  private $email;
  private $firstName;
  private $lastName;
  private $title;
  private $office;
  private $department;
  private $company;
  private $trans;

  function __construct() {
    $user = get_user_meta(get_current_user_id());

    $this->email      = $user["nickname"][0];
    $this->firstName  = $user["first_name"][0];
    $this->lastName   = $user["last_name"][0];
    $this->title      = $user["jobTitle"][0];
    $this->office     = $user["officeLocation"][0];
    $this->department = $user["department"][0];
    $this->company    = (!empty($user["companyName"][0]))?$user["companyName"][0]:"Skola";

    $this->trans = array( "å" => "a",
                          "ä" => "a",
                          "ö" => "o",
                          "é" => "e",
                          " " => "_");
  }

  /* get methods */
  function getFirstName() {
    return $this->firstName;
  }
  function getUserObject() {
    return array( 'email'       => $this->email,
                  'firstName'   => $this->firstName,
                  'lastName'    => $this->lastName,
                  'title'       => $this->title,
                  'office'      => $this->office,
                  'department'  => $this->department,
                  'company'     => $this->company
                );
  }

  function getCssIsClasses() {
    $cssIsClasses = array();
    foreach (array($this->firstName.$this->lastName, $this->title, $this->office, $this->department, $this->company, $this->getUserRole()) as $value) {
      if (!empty($value)) {
          $cssIsClasses[] = "is-" . strtolower(strtr($value, $this->trans));
      }
    }
    if (strpos($this->email, 'hkedu.se') !== false) {
      $cssIsClasses[] = "is-hkedu";
    }
    else {
      $cssIsClasses[] = "is-not-hkedu";
    }
    return $cssIsClasses;
  }

  /* helper methods */
  function getUserRole() {
    $user = wp_get_current_user();
  	return $user->roles ? $user->roles[0] : '';
  }
}
?>
