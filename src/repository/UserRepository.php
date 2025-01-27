<?php

require_once 'Repository.php';

class UserRepository extends Repository
{
    public function getUser(string $email) : ?User {
        $stmt = $this->db->connect()->prepare("SELECT * FROM public.users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User($user['id'],$user['email'], $user['password'], $user['name'], $user['surname'], $user['user_role']);
    }

    public function getUserByID(string $id) : ?User {
        $stmt = $this->db->connect()->prepare("SELECT * FROM public.users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User($user['id'],$user['email'], $user['password'], $user['name'], $user['surname'], $user['user_role']);
    }

    public function addUser(string $name, string $surname, string $email, string $password, string $role): void
    {
        $stmt = $this->db->connect()->prepare('
            INSERT INTO public.users (id, name, surname, email, password, user_role) VALUES (?, ?, ?, ?, ?, ?)
        ');

        $id = $this->howManyUsers() + 1;

        $stmt->execute([
            $id,
            $name,
            $surname,
            $email,
            $password,
            $role
        ]);
    }

    public function changePassword(string $password, string $id) : ?bool
    {
        $stmt = $this->db->connect()->prepare('
            UPDATE public.users SET password = ? WHERE id = ?
        ');
        $stmt->execute([
            $password,
            $id,
        ]);

        if ($stmt->rowCount() == 0) {
            return false;
        } else {
            return true;
        }
    }


    public function howManyUsers(): int
    {
        $baseStmt =  "SELECT COUNT(*) FROM public.users";

        try{
            $stmt = $this->db->connect()->prepare($baseStmt);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return (int)$count;
        }
        catch(PDOException $e){
            error_log($e->getMessage());
            return 0;
        }
    }

    public function isAdmin(int $id) : bool {
        $stmt = $this->db->connect()->prepare("SELECT users.user_role FROM public.users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user['user_role'] == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser(string $id) {
        $stmt = $this->db->connect()->prepare("DELETE FROM public.users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();

    }
}