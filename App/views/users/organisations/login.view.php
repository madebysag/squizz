<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Student_Login.css">
    <title>Login as Admin</title>
</head>
<body>
    <main>
        <div class="exam-info">
            <a href="/" class="btn-secondary"><< Back Home</a>
        </div>

        <form action="/auth/organisations/login" method="POST">
            <p class="text-lg text-condensed">Login as Organisation Admin</p>
            
            <div class="input-group">
                <label for="email" class="text-sm">Email</label>
                <input type="email" name="email" id="email" value="<?= $user["email"] ?? "" ?>">

                <?php if (isset($error["email"])) : ?>
                    <div class='error'><?= $error["email"] ?></div>
                <?php endif; ?>

            </div>
            
            <div class="input-group">
                <label for="password" class="text-sm">Password</label>
                <input type="password" name="password" id="password" >

                <?php if (isset($error["password"])) : ?>
                    <div class='error'><?= $error["password"] ?></div>
                <?php endif; ?>

            </div>
            
            <div class="input-group">
                <a href="/auth/forgetpassword" class="text-sm text-muted">Forget Password?</a>
            </div>
        
            <button type="submit" class="submit btn-primary">Login <b>>></b></button>
        </form>
    </main>
</body>
</html>