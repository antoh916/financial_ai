<div class="container">
    <h1>FAQ Management</h1>
    
    <div class="actions">
        <a href="<?php echo base_url('admin/faq/create'); ?>" class="btn btn-primary">Add New FAQ</a>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Category</th>
                <th>Order</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($faqs as $faq): ?>
                <tr>
                    <td><?php echo $faq->id; ?></td>
                    <td><?php echo $faq->question; ?></td>
                    <td><?php echo $faq->category; ?></td>
                    <td><?php echo $faq->order_number; ?></td>
                    <td><?php echo $faq->is_active ? 'Active' : 'Inactive'; ?></td>
                    <td>
                        <a href="<?php echo base_url('admin/faq/edit/' . $faq->id); ?>" class="btn btn-sm btn-info">Edit</a>
                        <a href="<?php echo base_url('admin/faq/delete/' . $faq->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this FAQ?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>