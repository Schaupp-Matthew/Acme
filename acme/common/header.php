<div>
    <a href="/acme/index.php" title="Acme Logo">
        <img alt="Acme Logo" id="logo" src="/acme/images/site/logo.gif">
    </a>
</div>

<div>
    <?php if(isset($cookieFirstname)) {echo "<span>Welcome $cookieFirstname!</span>";}
    if(isset($_SESSION['clientData']['clientFirstname'])){echo '<a href="/acme/accounts/index.php" class="welcome">Welcome ' . $_SESSION['clientData']['clientFirstname'] . '!</a><span>|</span>';}
    
    
    if(isset($_SESSION['loggedin']) == TRUE) {
        echo '<a href="/acme/accounts/index.php?action=Logout" class="logoutLink">Logout</a>';
    }
    else {
        echo '<a href="/acme/accounts/index.php?action=login" title="My Account" class="folderLink"><img alt="Account Logo" id="folder" src="/acme/images/site/account.gif">My Account</a>';
    }
    ?>
</div>

