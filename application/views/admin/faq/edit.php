<div class="container">
    <h1>Edit FAQ</h1>
    
    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    
    <?php echo form_open('admin/faq/edit/' . $faq->id); ?>
        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" class="form-control" id="question" name="question" value="<?php echo set_value('question', $faq->question); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="answer">Answer</label>
            <textarea class="form-control" id="answer" name="answer" rows="5" required><?php echo set_value('answer', $faq->answer); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" class="form-control" id="category" name="category" value="<?php echo set_value('category', $faq->category); ?>" required>
            <small class="text-muted">e.g. general, pricing, orders, etc.</small>
        </div>
        
        <div class="form-group">
            <label for="order_number">Order Number</label>
            <input type="number" class="form-control" id="order_number" name="order_number" value="<?php echo set_value('order_number', $faq->order_number); ?>" min="0">
        </div>
        
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?php echo set_checkbox('is_active', '1', $faq->is_active); ?>>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Update FAQ</button>
        <a href="<?php echo base_url('admin/faq'); ?>" class="btn btn-secondary mt-3">Cancel</a>
    <?php echo form_close(); ?>
</div>