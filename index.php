<?php
if (!empty($_SERVER['HTTP_REFERER']))
{
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
else
{
   header("Location: admin");
}
?>