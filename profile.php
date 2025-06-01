<?php
include('Connection/PDOcon.php');

session_start();


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Fetch user data (assuming user ID is stored in session)
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("User not logged in.");
}

$query = $pdo->prepare("SELECT * FROM user WHERE id = :id");
$query->execute(['id' => $user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // Edit Name
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
        if (!empty($name)) {
            $stmt = $pdo->prepare("UPDATE user  SET name = :name WHERE id = :id");
            $stmt->execute(['name' => $name, 'id' => $user_id]);
        } else {
            $errors[] = "Name cannot be empty.";
        }
    }

    // Edit Password
    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE user SET password = :password WHERE id = :id");
            $stmt->execute(['password' => $hashed_password, 'id' => $user_id]);
        } else {
            $errors[] = "Password cannot be empty.";
        }
    }

    // Edit Email
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
            $stmt->execute(['email' => $email, 'id' => $user_id]);
        } else {
            $errors[] = "Invalid email address.";
        }
    }

    // Edit Phone
    if (isset($_POST['phone'])) {
        $phone = trim($_POST['phone']);
        if (preg_match('/^[0-9]{10,15}$/', $phone)) {
            $stmt = $pdo->prepare("UPDATE users SET phone = :phone WHERE id = :id");
            $stmt->execute(['phone' => $phone, 'id' => $user_id]);
        } else {
            $errors[] = "Invalid phone number.";
        }
    }

    // Edit Address
    if (isset($_POST['address'])) {
        $address = trim($_POST['address']);
        if (!empty($address)) {
            $stmt = $pdo->prepare("UPDATE users SET address = :address WHERE id = :id");
            $stmt->execute(['address' => $address, 'id' => $user_id]);
        } else {
            $errors[] = "Address cannot be empty.";
        }
    }

    // Reload the updated data
    header("Location: profile.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<style>
body {
    color: #8e9194;
    background-color: #f4f6f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    width: 50%;
    margin: auto;
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.avatar-xl img {
    width: 110px;
}

.rounded-circle {
    border-radius: 50% !important;
}

img {
    vertical-align: middle;
    border-style: none;
}

.text-muted {
    color: #aeb0b4 !important;
}

.text-muted {
    font-weight: 300;
}

.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #4d5154;
    background-color: #ffffff;
    background-clip: padding-box;
    border: 1px solid #eef0f3;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
</style>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                <h2 class="h3 mb-4 page-title">Edit Profile</h2>
                <div class="my-4">
                    <div class="row mt-5 align-items-center justify-content-center">
                        <div class="col-md-3 text-center mb-5">
                            <div class="avatar avatar-xl">
                                <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="..."
                                    class="avatar-img rounded-circle" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <h4 class="mb-1">
                                        <h3>
                                            <?php echo htmlspecialchars($user['name']); ?>
                                        </h3>
                                    </h4>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <p class="small mb-0 text-muted">
                                        <?php echo htmlspecialchars($user['address']); ?></p>
                                    <p class="small mb-0 text-muted">
                                        <?php echo htmlspecialchars($user['email']); ?></p>
                                    <p class="small mb-0 text-muted">
                                        <?php echo htmlspecialchars($user['phone']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="editProfileBtn">Edit Profile</button>
                    <button id="resetPasswordBtn">Reset Password</button>
                    <hr class="my-4" />
                    <form method="POST" class="form-section" id="editProfileForm" style="display: none;">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="firstname">Name</label>
                                <input type="text" id="firstname" class="form-control" placeholder="Brown"
                                    value="<?php echo htmlspecialchars($user['name']); ?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" placeholder="brown@asher.me"
                                value="<?php echo htmlspecialchars($user['email']); ?>" required />
                        </div>
                        <div class="form-group">
                            <label for="inputAddress5">Address</label>
                            <input type="text" class="form-control" id="inputAddress5"
                                value="<?php echo htmlspecialchars($user['address']); ?>" required />
                        </div>
                        <div class="form-group">
                            <label for="inputAddress5">Phone</label>
                            <input type="text" class="form-control" id="inputAddress5"
                                value="<?php echo htmlspecialchars($user['phone']); ?>" required />
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit">Save Changes</button>
                        </div>
                    </form>
                    <button type="cancel" id="cancelEditProfile" style="display: none;">Cancel</button>
                    <form method="POST" class="form-section" id="resetPasswordForm" style="display: none;">
                        <hr class="my-4" />
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputPassword5">New Password</label>
                                    <input type="password" class="form-control" id="inputPassword5" />
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword6">Confirm Password</label>
                                    <input type="password" class="form-control" id="inputPassword6" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">Password requirements</p>
                                <p class="small text-muted mb-2">To create a new password, you have to meet all of the
                                    following requirements:</p>
                                <ul class="small text-muted pl-4 mb-0">
                                    <li>Minimum 8 character</li>
                                    <li>At least one special character</li>
                                    <li>At least one number</li>
                                    <li>Can’t be the same as a previous password</li>
                                </ul>
                            </div>
                        </div>
                        <button type="submit">Reset Password</button>
                    </form>
                    <button type="cancel" id="cancelEditPassword" style="display: none;">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Toggle Edit Profile Form
    document.getElementById('editProfileBtn').addEventListener('click', () => {
        let editProfileForm = document.getElementById('editProfileForm');
        let resetPasswordForm = document.getElementById('resetPasswordForm');
        let cancelEditProfile = document.getElementById('cancelEditProfile');

        editProfileForm.style.display = (editProfileForm.style.display === 'none' || editProfileForm.style
            .display === '') ? 'block' : 'none';
        cancelEditProfile.style.display = (cancelEditProfile.style.display === 'none' || cancelEditProfile.style
            .display === '') ? 'block' : 'none';

        resetPasswordForm.style.display = 'none';
        document.getElementById('cancelEditPassword').style.display = 'none';
    });

    document.getElementById('resetPasswordBtn').addEventListener('click', () => {
        let editProfileForm = document.getElementById('editProfileForm');
        let resetPasswordForm = document.getElementById('resetPasswordForm');
        let cancelEditPassword = document.getElementById('cancelEditPassword');

        resetPasswordForm.style.display = (resetPasswordForm.style.display === 'none' || resetPasswordForm.style
            .display === '') ? 'block' : 'none';
        cancelEditPassword.style.display = (cancelEditPassword.style.display === 'none' || cancelEditPassword
            .style.display === '') ? 'block' : 'none';

        // Hide edit profile form if open
        editProfileForm.style.display = 'none';
        document.getElementById('cancelEditProfile').style.display = 'none';
    });

    document.getElementById('cancelEditProfile').addEventListener('click', () => {
        document.getElementById('editProfileForm').style.display = 'none';
        document.getElementById('cancelEditProfile').style.display = 'none';
    });

    // Cancel Reset Password
    document.getElementById('cancelEditPassword').addEventListener('click', () => {
        document.getElementById('resetPasswordForm').style.display = 'none';
        document.getElementById('cancelEditPassword').style.display = 'none';
    });
    </script>
</body>


</html>