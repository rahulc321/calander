<div class="modal-dialog">
    <div class="modal-content">
        <form method="post" action="{{ sysUrl('users/message-inactive/'.encryptIt($user->id)) }}"
              class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Send Message</h4>
            </div>
            <div class="modal-body with-padding">
                <ul>
                    @foreach($user->messages as $message)
                        <li>{{ $message->message }}<br>
                            <span class="text-primary">on {{ $message->createdDate() }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="form-group">
                    <input type="hidden" name="inactive_user_id">
                    <div class="col-md-12">
                        <label>Message:</label>
                        <div>
                            <textarea class="form-control" name="message" style="height:150px;"></textarea>
                        </div>
                    </div>
                </div>
                <label>Send Email <input type="checkbox" class="checkbox-inline" name="sendEmail" value="1"> </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>
</div>