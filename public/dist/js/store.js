var Store = {
    modalSelector: "#modalForm",

    init: function () {
        this.onLoad();
        this.onModalOpenEdit();
        this.onModalSave();
        this.onModalAdd();
        this.onRemoveRow();
    },
    onLoad: function() {
        StoreNotifications.show();
    },
    onModalOpenEdit: function () {
        jQuery('.js-modal-form-edit-open').on('click', function(e) {
            e.preventDefault();
            let id        = jQuery(this).data('id'),
                modal     = jQuery('#modalForm'),
                storeName = modal.data('store_name');

            StoreApi.get('/api/v2/render/edit/'+storeName+'/'+id, function(data) {
                modal.find('.modal-body').html(data);
                modal.data('id', id);
                modal.modal('toggle');
                //console.log(data);
            });
        });
    },
    onModalSave: function () {
        jQuery('.js-modal-form-edit-save').on('click', function(e) {
            e.preventDefault();

            let formData = {},
                $modal   = jQuery(Store.modalSelector),
                $form    = $modal.find('form'),
                action   = $form.attr('action'),
                id       = $modal.data('id');

            $form.find('input, textarea, select').each(function () {
                formData[this.name] = jQuery(this).val();
            })
            if (id) {
                //XXX: Edit
                console.log(formData);
                StoreApi.post(action+id, formData, function (data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $modal.modal('toggle');
                        //StoreNotifications.success('Success Change!', 'Row ID#'+id+' was changed!');
                        //location.reload();
                    }

                    //XXX: add logic validate fields
                    if (data.status == 'error') {
                        jQuery('.error').text(data.message);
                    }
                });
            } else {
                //Insert
                StoreApi.post(action, formData, function (data) {
                    if (data.status == 'success') {
                        $modal.modal('toggle');
                        StoreNotifications.success("Add", "Row was added!");
                        location.reload();

                    }

                    //XXX: add logic validate fields
                    if (data.status == 'error') {
                        jQuery('.error').text(data.message);
                    }


                });
            }

        })
    },
    onModalAdd: function () {
        jQuery('.js-form-add').on('click', function(e) {
            let $modal    = jQuery(Store.modalSelector),
                storeName = $modal.data('store_name');

            StoreApi.get('/api/v2/render/add/'+storeName, function(data) {
                $modal.find('.modal-body').html(data);
                $modal.modal('toggle');
                //console.log(data);
            });
        });
    },
    onRemoveRow: function() {
        jQuery('.js-remove-row').on('click', function(e) {
            e.preventDefault();
            let id     = jQuery(this).data('id'),
                action = jQuery(this).data('action');

            if (confirm("Do you want remove row. ID#"+id)) {
                StoreApi.delete(action+id, function (data) {
                    if (data.status == 'success') {
                        StoreNotifications.success("Deleted", "Row ID#"+id+" was deleted!");
                        location.reload();
                        return;
                    }
                });

            }
        })
    }
};

var StoreApi = {
    //XXX: add Access Token to headers
    post: function (url, formData, callback) {
        jQuery.post(url, formData, function (data) {
            callback(data);
        });
    },
    get: function (url, callback) {
        jQuery.get(url, function (data) {
            callback(data);
        });
    },
    delete: function(url, callback) {
        $.ajax({
            type: "DELETE",
            url: url,
            success: callback,
        });
    }
};

var StoreNotifications = {
    name: 'notification',
    type_success: 'success',
    type_error: 'error',

    add: function(type, title = null, message = null) {
        let data = {
            'type': type,
            'title': title,
            'message': message
        };
        jQuery.cookie(this.name, JSON.stringify(data));
    },

    success: function(title = null, message = null) {
        this.add(this.type_success, title, message);
    },

    error: function(title = null, message = null) {
        this.add(this.type_error, title, message);
    },

    show: function () {
        if (jQuery.cookie(this.name) && jQuery.cookie(this.name) !== 'null') {

            let cookieData = jQuery.cookie(this.name);
            //is Json
            let notification = jQuery.parseJSON(cookieData),
                $notificationContainer = jQuery('.js-notifications-success');

            this._removeTypeClasses($notificationContainer);
            if (notification.type == this.type_success) {
                $notificationContainer.addClass('alert-success')

                //$notificationContainer.removeClass('d-none');
            } else if (notification.type == this.type_error) {
                $notificationContainer.addClass('alert-danger')

            }

            if (notification.title) {
                $notificationContainer.find('.js-title').html(notification.title);
            }
            if (notification.message) {
                $notificationContainer.find('.js-body').html(notification.message);
            }

            $notificationContainer.show('slow');
            jQuery.cookie(this.name, null);
            setTimeout(function () {
                $notificationContainer.hide('slow');
            }, 5000);
        }
    },

    _removeTypeClasses: function($container) {
        $container.removeClass('alert-success').removeClass('alert-danger');
    }

}

jQuery(function() {
    Store.init();
});
