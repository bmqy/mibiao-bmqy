<?php
/**
 * Created by IntelliJ IDEA.
 * User: bmqy
 * Date: 2017/9/27
 * Time: 12:51
 */
if(empty($_COOKIE['userId'])){
    redirect('/admin/login.php');
}