<div class="container mt-5" style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 8px 18px rgba(0,0,0,0.2); font-family: 'Poppins', sans-serif;">
    <h2 style="text-align: center; color: #641B2E; margin-bottom: 25px;">Edit Profile</h2>

    <?= form_open('teacher/update_profile') ?>

    <div class="form-group mb-3">
        <label for="name" style="color: #641B2E;">First Name</label>
        <input type="text" name="first_name" class="form-control" value="<?= set_value('first_name', $teacher['first_name']) ?>" required>
        <small class="text-danger"><?= form_error('first_name') ?></small>
    </div>

    <div class="form-group mb-3">
        <label for="name" style="color: #641B2E;">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="<?= set_value('last_name', $teacher['last_name']) ?>" required>
        <small class="text-danger"><?= form_error('last_name') ?></small>
    </div>

    <div class="form-group mb-3">
        <label for="email" style="color: #641B2E;">Email</label>
        <input type="email" name="email" class="form-control" value="<?= set_value('email', $teacher['email']) ?>" required>
        <small class="text-danger"><?= form_error('email') ?></small>
    </div>

    <div class="form-group mb-3">
        <label for="phone" style="color: #641B2E;">Phone</label>
        <input type="text" name="phone" class="form-control" value="<?= set_value('phone', $teacher['phone']) ?>" required>
        <small class="text-danger"><?= form_error('phone') ?></small>
    </div>

    <div class="form-group mb-3">
        <label for="department" style="color: #641B2E;">Department</label>
        <input type="text" name="department" class="form-control" value="<?= set_value('department', $teacher['department']) ?>" required>
        <small class="text-danger"><?= form_error('department') ?></small>
    </div>

    <div class="form-group mb-4">
        <label for="password" style="color: #641B2E;">New Password (optional)</label>
        <input type="password" name="password" class="form-control">
        <small class="text-danger"><?= form_error('password') ?></small>
    </div>

    <button type="submit" class="btn btn-block" style="background-color: #BE5B50; color: white; font-weight: 600; padding: 10px; border-radius: 6px;">Update Profile</button>
    <button type="cancel" class="btn btn-block" style="background-color: #BE5B50; color: white; font-weight: 600; padding: 10px; border-radius: 6px;">Cancel</button>

    <?= form_close() ?>
</div>