<?php
session_start();
include('dbcon.php');

if(isset($_POST['login_btn']))
{
    $email = $_POST['email'];
    $clearTextPassword = $_POST['password'];

    try {
        $user = $auth->getUserByEmail("$email");
    
        try{
            $signInResult = $auth->signInWithEmailAndPassword($email, $clearTextPassword);
            $idTokenString = $signInResult->idToken();
    

            try {
                $verifiedIdToken = $auth->verifyIdToken($idTokenString);
                $uid = $verifiedIdToken->claims()->get('sub');

                $claims = $auth->getUser($uid)->customClaims;
                if(isset($claims['admin']) == true)
                {
                    $_SESSION['verified_admin'] = true;
                    $_SESSION['verified_user_id'] = $uid;
                    $_SESSION['idTokenString'] = $idTokenString;
                }
                elseif(isset($claims['super_admin']) == true)
                {
                    $_SESSION['verified_super_admin'] = true;
                    $_SESSION['verified_user_id'] = $uid;
                    $_SESSION['idTokenString'] = $idTokenString;
                }
                elseif($claims == null)
                {
                    $_SESSION['verified_user_id'] = $uid;
                    $_SESSION['idTokenString'] = $idTokenString;
                }


                $_SESSION['status'] = "Logged in succesfully";
                header('Location: home.php'); 
                exit();
                
            }catch (InvalidToken $e) {
                $_SESSION['status'] = 'The token is invalid: ' .$uid.' -- '. $idTokenString.$e->getMessage();
                header('Location: login.php');
                exit();
            }catch (\InvalidArgumentException $e) {
                $_SESSION['status'] = 'Error parsing token: ' .$uid.' -- '. $idTokenString.$e->getMessage();
                header('Location: login.php');
                exit();
            }


        }
        catch(Exception $e){
            $_SESSION['status']= " Wrong Password";
            header('Location: login.php'); 
            exit();
        }
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e){
        //echo $e->getMessage();
        
        $_SESSION['status']= " Invalid Email Address";
        header('Location: login.php'); 
        exit();
    }

}
else
    {
        $_SESSION['status']= " Not Allowed";
        header('Location: login.php'); 
        exit();
    }
?>