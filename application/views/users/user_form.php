<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>TIKET KONSER</title>
</head>
<body>

            <h4>USER FORM</h4>

                <?php if ($this->session->flashdata('msg')): ?>
                        <?= $this->session->flashdata('msg'); ?>
                <?php endif; ?>           

                <?php
                $username = $password = $fullname =  '';
                if (isset($user)) {
                    $username = $user->username ?? '';
                    $password = $user->password ?? '';
                    $fullname = $user->fullname ?? '';
                }
                ?>

                <form action="" method="post">
                    <table>
                        <tr>
                            <td>Username</td>
                            <td><input type="text" name="username" value="<?=$username?>" required></td>
                        </tr>
                        <tr>
                            <td>Fullname</td>
                            <td><input type="text" name="fullname" value="<?=$fullname?>" required></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type="password" name="password" value="<?=$password?>" required></td>
                        </tr>
                    </table>

                        <input type="submit" name="submit" value="SAVE">
                        <a href="<?=site_url('users')?>">
                            <i>CANCEL</i> 
                    
                </form>

</body>
</html>
