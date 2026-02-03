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
        <form action="/users" method="POST">
            <p class="text-lg text-condensed">Register New User</p>
            <div class="input-group">
                <label for="role" class="text-sm">Role</label>
                <select name="role" id="role">
                    <option value="student">Student</option>
                    <option value="tutor">Tutor</option>
                </select>
            </div>

            <div class="input-group">
                <label for="name" class="text-sm">Full Name - surname last*</label>
                <input type="text" name="name" id="name" >
            </div>
            
            <div class="input-group">
                <label for="email" class="text-sm">Email</label>
                <input type="text" name="email" id="email" >
            </div>
            
            <div class="input-group">
                <label for="password" class="text-sm">Password</label>
                <input type="password" name="password" id="password" >
                <!-- <div class="error">Invalid Credentials</div> -->
            </div>
            
            <div class="input-group">
                <label for="password2" class="text-sm">Confirm Password</label>
                <input type="password" name="password2" id="password2" >
                <!-- <div class="error">Invalid Credentials</div> -->
            </div>
            <button type="submit" class="submit btn-primary">Register <b>>></b></button>
        </form>
    </main>
</body>
</html>