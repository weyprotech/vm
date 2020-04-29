<div class="popup_block">
    <div class="popup_inner popup_form popup_justForYou">
        <h2 class="block_title has_icon">
            <span><i class="icon_just_for_you"></i>Just for you</span>
        </h2>
        <div class="text">
            Vestibulum rutrum quam vitae fringilla tincidunt. Suspendisse nec tortor urna. Ut laoreet sodales nisi, quis iaculis nulla iaculis vitae. Donec sagittis faucibus lacus eget blandit.
        </div>
        <form class="form_wrapper" id="just_form" method="post">
            <input type="hidden" name="designerId" value="<?= $designerId ?>">
            <div class="form_block">
                <div class="controls_group">
                    <label>Your Name</label>
                    <div class="controls">
                        <input type="text" name="name" required/>
                    </div>
                </div>
                <div class="controls_group">
                    <label>Contact Email</label>
                    <div class="controls">
                        <input type="email" name="email" required/>
                    </div>
                </div>
                <div class="controls_group">
                    <label>A made to order function</label>
                    <div class="controls">
                        <textarea placeholder="Hello! Leave a message…" name="message" required></textarea>
                    </div>
                </div>
            </div>
            <div class="call_action">
                <button class="btn common" type="button" id="just_send">Send</button>
            </div>
        </form>
    </div>
</div>