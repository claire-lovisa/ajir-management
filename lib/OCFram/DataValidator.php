<?php
namespace OCFram;

trait DataValidator
{
  public function verificationEmailExiste($email, $nomModule) {
    $countEmail = $this->managers->getManagerOf($nomModule)->countEmail($email);
    return $countEmail>0;
  }

  private function verificationMdpCorrect($passwordHache, $nomModule, $email) {
    return $passwordHache == $this->managers->getManagerOf($nomModule)->getMdpHache($email);
  }

}
