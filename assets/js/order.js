let $collectionHolder;

// setup an "add a tag" link
const $addTagButton = $('<button type="button" class="btn btn-outline-success add_items_link">Agregar almuerzo</button>');
const $newLinkLi = $('<li class="list-group-item"></li>').append($addTagButton);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('#order_items');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addOrderItemsForm($collectionHolder, $newLinkLi);
    });

    function managerefreshAddresses() {
        const $getAddressesButton = $('<button type="button" class="btn-sm btn-outline-success mt-2">Refrescar direcciones</button>');
        $('#order_user').after($getAddressesButton);
        $getAddressesButton.on('click', function ($e) {
            const addressSelect = $('#order_address');
            // Remove current options
            addressSelect.html('');
            // Empty value ...
            addressSelect.append('<option value>Selecciona una dirección</option>');
            let user_id = $('#order_user').find(":selected").val();
            console.log(user_id)
            $.ajax('/api/form-ajax/addresses-by-user/' + user_id).done(function (data) {
                if (data) {
                    // Remove current options
                    addressSelect.html('');
                    // Empty value ...
                    addressSelect.append('<option value>Selecciona una dirección</option>');
                    $.each(data, function (key, address) {
                        addressSelect.append('<option value="' + address.id + '">' + address.address + '</option>');
                    });
                    addressSelect.multipleSelect('refreshOptions', {})
                }
            });
        });
    }

    function manageIngredientsDisplay() {
        const $orderItems = $('.multiple-order-item fieldset');
        $orderItems.each(function() {
            const $selectLunches = $(this).find("select[id*='lunch']");
            const isCustom = $selectLunches.find('option:selected').attr('data-is-custom');
            if (isCustom) {
                $(this).find('.ingredients-container').show();
            }
            else {
                $(this).find('.ingredients-container').hide();
            }
            // Attach event.
            $selectLunches.on('change', ingredientsDisplayOnChange);
        });
    }

    managerefreshAddresses();
    manageIngredientsDisplay();
});

function addOrderItemsForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    const prototype = $collectionHolder.data('prototype');

    // get the new index
    const index = $collectionHolder.data('index');

    let newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    let $newForm = $(newForm);
    $newForm.find('select').multipleSelect({ selectAll: false });
    $newForm.find('#order_items_' + index + ' .ingredients-container').hide();
    $newForm.find('#order_items_' + index + '_lunch').on('change', ingredientsDisplayOnChange);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    const $newFormLi = $('<li class="list-group-item"></li>').append($newForm);
    $newLinkLi.before($newFormLi);
}

// Show or hide ingredients select.
function ingredientsDisplayOnChange() {
    const isCustom = $(this).find('option:selected').attr('data-is-custom');
    if (isCustom) {
        $(this).parent().next('.ingredients-container').show();
    }
    else {
        $(this).parent().next('.ingredients-container').hide();
    }
}
