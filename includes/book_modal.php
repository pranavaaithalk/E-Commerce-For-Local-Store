<div class="modal fade" id="book-modal" tabindex="-1" role="dialog" aria-labelledby="filter-heading" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="filter-heading">CONFIRM BOOKING!</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                <h4>Note: Payment Through Cash On Delivery Only</h4>
                <h5>Please Confirm Your Order!</h5>
                <form id="book-form" class="form" role="form" method="post" action="api/book_submit.php">
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Confirm</button>
                    </div>
                </form>
                <button data-dismiss="modal" class="btn btn-block btn-primary">Cancel</button>
                </div>
                
                <div class="modal-footer">
                    Missed Something? <a href="../Ecom/shopping.php">Click here</a>
                    to add item.
                </div>
            </div>
        </div>
    </div>