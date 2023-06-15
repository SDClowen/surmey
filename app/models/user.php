<?php
namespace App\Models;

use Core\{Model, Database};

class User extends Model
{
    public static function validateAuth($value, $password)
    {
        $column = strpos($value, "@") ? "email" : "username";

        return Database::get()->from("users")->where($column, "=", $value)->where("password", "=", $password)->result();
    }

    /**
     * Get user id from the session
     */
    public static function id() : int {
        $user = self::info();

        return $user->id;
    }

    /**
     * Get user info from the session
     */
    public static function info(){
        $user = session_get("user");

        return $user;
    }

     /**
     * Get user by id from the database
     */
    public static function getUserById(int $id)
    {
        return Database::get()->from("users")->where("id", "=", $id)->result();
    }

    
    /**
     * Update user data
     */
    public static function update(array $data)
    {
        return Database::get()->from("users")
            ->where("id", "=", self::id())
            ->update($data);
    }

    /**
     * Update user data by speficed column
     */
    public static function updateBy($column, $value, array $data, $op = "=")
    {
        return Database::get()->from("users")
            ->where($column, $op, $value)
            ->update($data);
    }

    /**
     * Delete row via id directly
     */
    public static function nativeDelete(int $id)
    {
        return Database::get()->from("users")
            ->where("id", "=", $id)
            ->delete();
    }

    /**
     * Check the row is exists: true otherwise false via specific column and value
     */
    public static function exists($column, $value)
    {
        return Database::get()->select("count(id)")
                    ->from("users")
                    ->where($column, "=", $value)
                    ->first();
    }
}
