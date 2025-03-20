<?php
    class UserContrller {
        public $user;
        public $password;
        public $email;

        function login() {
            
        }

        public function getEmail()
        {
                return $this->email;
        }

        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        public function getPassword()
        {
                return $this->password;
        }

        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }
        
        public function getUser()
        {
                return $this->user;
        }

        
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }
    }
?>