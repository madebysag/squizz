<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/Student_Login.css">
    <title>Register New User</title>
</head>
<body>
    <main>
        <div class="exam-info">
            <a href="/" class="btn-secondary"><< Back Home</a>
        </div>

        <form action="/auth/users/register" method="POST">
            <p class="text-lg text-condensed">Register New User</p>
            <div class="input-group">
                <label for="role" class="text-sm">Role</label>
                <select name="role" id="role">
                    <option value="student">Student</option>
                    <option value="tutor">Tutor</option>
                </select>
            </div>

            <div class="input-group">
                <label for="name" class="text-sm">Full Name - firstname first*</label>
                <input type="text" name="name" id="name" value="<?= $user["name"] ?? "" ?>" >

                <?php if (isset($error["name"])) : ?>
                    <div class='error'><?= $error["name"] ?></div>
                <?php endif; ?>            
            
            </div>
            
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
                <label for="password2" class="text-sm">Confirm Password</label>
                <input type="password" name="password2" id="password2" >

                <?php if (isset($error["password2"])) : ?>
                    <div class='error'><?= $error["password2"] ?></div>
                <?php endif; ?>  

            </div>
            <button type="submit" class="submit btn-primary">Register <b>>></b></button>
        </form>
    </main>
</body>
</html>