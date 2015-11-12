<?php
    /**
     * Méthode permettant la récupération de tous les utilisateurs
     * @return array $tab contentant tous les users
     */
		/*define('HOST','localhost');
		define('USER','root');
		define('PASS','LUCIENNE1223');
		define('DB','projetintegration');
		$con = mysqli_connect(HOST,USER,PASS,DB);
	 */
	 
    function getAllUser() {
        $query="SELECT * FROM user";
        if($result=mysqli_query($con,$query)){
			$nbResult=mysqli_num_rows($result);
			return $nbResult;			
    }

     function getUserById($id)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $query->execute(array(
            ":id" => $id
        ));

        $tabUser = $query->fetch(PDO::FETCH_ASSOC);

        $userToConnect = new User($tabUser);
        $tabDroit = $this->getUserDroit($userToConnect);
        $userToConnect->setDroit($tabDroit);

        return $userToConnect;
    }
	
     function nbUserByUsername($userName){		
		$query="SELECT * FROM user WHERE userName ='".$userName."' ";
        if($result=mysqli_query($con,$query)){
			$nbResult=mysqli_num_rows($result);
			return $nbResult;		
		
		}
	}
		
		
     function nbUserByEmail($email)
    {
	$query="SELECT * FROM user WHERE email = '".$email."'";
        if($result=mysqli_query($con,$query)){
			$nbResult=mysqli_num_rows($result);
			return $nbResult;		
		
		}
    }
     function getUserDroit(User $user)
    {
        $dm = new DroitManager(connexionDb());
        $query = $this->db->prepare("SELECT * FROM user_droit WHERE id_User = :idUser");
        $query->execute(array(
            ":idUser" => $user->getId()
        ));

        $tabDroit = $query->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();
        foreach($tabDroit as $elem)
        {
            $droitUser = $dm->getDroitById($elem['id_Droits']);
            $tab[] = $droitUser;

        }
        return $tab;
    }

     function addUser(User $user)
    {
        $query = $this
            ->db
            ->prepare("INSERT INTO user(UserName, Mdp, DateInscription, email) VALUES (:username , :mdp , NOW(), :email)");
        $user-> setMdp(hash("sha256", $user->getMdp()));
        $query->execute(array(
            ":username" => $user->getUserName(),
            ":mdp" => $user->getMdp(),
            ":email" => $user->getEmail(),
        ));
    }

     function updateUserProfil(User $user)
    {
        if(!empty($_POST['Private']))
        {
            $query = $this
                ->db
                ->prepare("UPDATE user SET UserName = :username , Mdp = :mdp , tel = :tel , isPrivate = :private WHERE id = :id");

            $query
                ->execute(array(
                    ":id" => $user->getId(),
                    ":username" => $user->getUserName(),
                    ":mdp" => $user->getMdp(),
                    ":tel" => $user->getTel(),
                    ":private" => $_POST['Private'],
                ));
        }
        else
        {
            $query = $this
                ->db
                ->prepare("UPDATE user SET UserName = :username , Mdp = :mdp , tel = :tel, isPrivate = 0 WHERE id = :id");

            $query
                ->execute(array(
                    ":id" => $user->getId(),
                    ":username" => $user->getUserName(),
                    ":mdp" => $user->getMdp(),
                    ":tel" => $user->getTel(),
                ));
        }

    }

     function updateUserConnect(User $user)
    {
        $query = $this
            ->db
            ->prepare("UPDATE user SET DateLastConnect = NOW() WHERE id = :id");

        $query
            ->execute(array(
                ":id" => $user->getId(),
            ));

    }

     function updateUserMdp (User $user) {

        $query = $this
            -> db
            ->prepare("UPDATE user SET Mdp = :mdp where id = :id");
        $user->setMdp(hash("sha256", $user->getMdp()));
        $query
            ->execute(array(
                ":id" => $user->getId(),
                ":mdp" => $user->getMdp(),
            ));
    }

}

?>