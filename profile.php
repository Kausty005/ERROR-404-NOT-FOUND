<?php
include 'config.php';
//session_start();

if (!isset($_SESSION['email'])) {
    header("Location:register.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM profile WHERE email='$email'";
$result = mysqli_query($con, $query);
$profile = mysqli_fetch_assoc($result);

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $medicalhistory = $_POST['medicalhistory'];
    $bloodgroup = $_POST['bloodgroup'];
    $gender = $_POST['gender'];

    if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
        $filename = $_FILES['file']['name'];
        $tempfile = $_FILES['file']['tmp_name'];
        $folder = 'images/'.$filename;
        move_uploaded_file($tempfile, $folder);
    } else {
        $folder = $profile['profile_image'] ?? '';
    }

    if($profile) {
        $update = "UPDATE profile SET name='$name', age='$age', height='$height', weight='$weight', medical_history='$medicalhistory', blood_group='$bloodgroup', gender='$gender', profile_image='$folder' WHERE email='$email'";
        mysqli_query($con, $update);
    } else {
        $insert = "INSERT INTO profile (email,profile_image,  name, age, height, weight, medical_history, blood_group, gender) VALUES ('$email','$folder','$name', '$age', '$height', '$weight', '$medicalhistory', '$bloodgroup', '$gender')";
        mysqli_query($con, $insert);
    }
    header('Location: profile.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}


.profile-box {
    background: #fff;
    padding: 40px 32px 32px 32px;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    width: 150%;
    max-width: 920px;
    text-align: center;
    animation: boxReveal 0.8s cubic-bezier(.4,0,.2,1) forwards;
    opacity: 0;
    transform: translateY(30px);
}

@keyframes boxReveal {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.profile-box h2 {
    margin-bottom: 28px;
    color: #222;
    font-size: 2rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.profile-picture {
    width: 120px;
    height: 120px;
    margin: 0 auto 24px auto;
    background: #f3f4f6;
    border-radius: 50%;
    border: 3px solid #e0e7ff;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    overflow: hidden;
    transition: box-shadow 0.3s, border-color 0.3s;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    position: relative;
    font-size: 2.2rem;
    color: #a5b4fc;
}

.profile-picture:hover {
    border-color: #6366f1;
    box-shadow: 0 4px 16px #6366f14d;
}

.profile-picture img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.input-group {
    margin: 18px 0 0 0;
    position: relative;
    text-align: left;
}

.input-group input,
.input-group select,
.input-group textarea {
    width: 100%;
    padding: 13px 12px 13px 12px;
    font-size: 1rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 7px;
    background: #f9fafb;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    margin-top: 8px;
}

.input-group input:focus,
.input-group select:focus,
.input-group textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 2px #6366f133;
}

.input-group label {
    position: absolute;
    top: 0;
    left: 14px;
    transform: translateY(-50%);
    background: #fff;
    padding: 0 6px;
    color: #7b7b7b;
    font-size: 0.98rem;
    pointer-events: none;
    transition: all 0.2s;
    opacity: 0.85;
}

.input-group input:focus+label,
.input-group input:not(:placeholder-shown)+label,
.input-group select:focus+label,
.input-group select:not([value=""])+label,
.input-group textarea:focus+label,
.input-group textarea:not(:placeholder-shown)+label {
    top: -16px;
    left: 8px;
    font-size: 0.88rem;
    color: #6366f1;
    background: #fff;
    opacity: 1;
}

.btn {
    margin-top: 28px;
    padding: 12px 0;
    width: 48%;
    font-size: 1.07rem;
    color: #fff;
    background: linear-gradient(90deg, #6366f1 0%, #4f46e5 100%);
    border: none;
    border-radius: 7px;
    cursor: pointer;
    font-weight: 500;
    letter-spacing: 0.2px;
    transition: background 0.25s, box-shadow 0.2s;
    box-shadow: 0 2px 8px #6366f12a;
    display: inline-block;
}

.btn:hover {
    background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%);
    box-shadow: 0 4px 16px #6366f14d;
}

.btn + .btn {
    margin-left: 4%;
    background: #a5b4fc;
    color: #222;
}

@media (max-width: 600px) {
    .profile-box {
        padding: 18px 6vw;
        max-width: 98vw;
    }
    .btn {
        width: 100%;
        margin-top: 18px;
    }
    .btn + .btn {
        margin-left: 0;
        margin-top: 12px;
    }
}
    </style>
</head>

<body>
    <form method="post" action="profile.php" enctype="multipart/form-data" autocomplete="off">
        <div class="profile-box">
            <h2>Profile Page</h2>
            <div class="profile-picture" id="profilePicture" title="Click to upload/change your photo">
                <?php if(!empty($profile['profile_image'])) { ?>
                    <img src="<?php echo htmlspecialchars($profile['profile_image']); ?>" alt="Profile Picture">
                <?php } else { ?>
                    <span style="font-size:2.5rem; color:#a5b4fc;">&#128247;</span>
                <?php } ?>
            </div>
            <input type="file" name="file" id="fileInput" style="display: none;" accept="image/*">
            
            <div class="input-group">
                <input type="text" name="name" id="name" placeholder=" " value="<?php echo htmlspecialchars($profile['name'] ?? ''); ?>" required>
                <label for="name">Name</label>
            </div>

            <div class="input-group">
                <input type="number" name="age" id="age" placeholder=" " value="<?php echo htmlspecialchars($profile['age']??"");?>" required>
                <label for="age">Age</label>
            </div>

            <div class="input-group">
                <input type="number" name="height" id="height" placeholder=" " value="<?php echo htmlspecialchars($profile['height']??"");?>" required>
                <label for="height">Height (cm)</label>
            </div>

            <div class="input-group">
                <input type="number" name="weight" id="weight" placeholder=" " value="<?php echo htmlspecialchars($profile['weight']??"");?>" required>
                <label for="weight">Weight (kg)</label>
            </div>

            <div class="input-group">
                <textarea id="medicalHistory" name="medicalhistory" rows="4" placeholder=" " required><?php echo htmlspecialchars($profile['medical_history']??"");?></textarea>
                <label for="medicalHistory">Medical History</label>
            </div>

            <div class="input-group">
                <select id="bloodGroup" name="bloodgroup" placeholder=" " required>
                    <option value="" disabled <?php if (empty($profile['blood_group'])) echo 'selected'; ?>></option>
                    <option value="A+" <?php if (($profile['blood_group'] ?? '') == 'A+') echo 'selected'; ?>>A+</option>
                    <option value="A-" <?php if (($profile['blood_group'] ?? '') == 'A-') echo 'selected'; ?>>A-</option>
                    <option value="B+" <?php if (($profile['blood_group'] ?? '') == 'B+') echo 'selected'; ?>>B+</option>
                    <option value="B-" <?php if (($profile['blood_group'] ?? '') == 'B-') echo 'selected'; ?>>B-</option>
                    <option value="O+" <?php if (($profile['blood_group'] ?? '') == 'O+') echo 'selected'; ?>>O+</option>
                    <option value="O-" <?php if (($profile['blood_group'] ?? '') == 'O-') echo 'selected'; ?>>O-</option>
                    <option value="AB+" <?php if (($profile['blood_group'] ?? '') == 'AB+') echo 'selected'; ?>>AB+</option>
                    <option value="AB-" <?php if (($profile['blood_group'] ?? '') == 'AB-') echo 'selected'; ?>>AB-</option>
                </select>
                <label for="bloodGroup">Blood Group</label>
            </div>

            <div class="input-group">
                <select id="gender" name="gender" placeholder=" " required>
                    <option value="" disabled <?php if (empty($profile['gender'])) echo 'selected'; ?>></option>
                    <option value="Male" <?php if (($profile['gender'] ?? '') == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if (($profile['gender'] ?? '') == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if (($profile['gender'] ?? '') == 'Other') echo 'selected'; ?>>Other</option>
                </select>
                <label for="gender">Gender</label>
            </div>
            <button class="btn" type="submit" name="submit">Save Profile</button>
            <button type="button" class="btn" onclick="window.location.href='index.php';">Back</button>
        </div>
    </form>
    <script>
        const profilePicture = document.getElementById('profilePicture');
        const fileInput = document.getElementById('fileInput');

        profilePicture.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    profilePicture.innerHTML = `<img src="${e.target.result}" alt="Profile Picture">`;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
