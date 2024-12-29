<div class="container">
    <h2>User Management</h2>
    
    <div id="userFormContainer" style="display: none;" class="mb-4">
        <div class="card">
            <div class="card-header">
                <h5 id="formTitle">Add New User</h5>
            </div>
            <div class="card-body">
                <form id="userForm">
                    <input type="hidden" id="userId" name="userId">
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="text-muted">Leave empty to keep existing password when editing</small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" id="cancelUserForm">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <?php user_view(); ?>
</div>
