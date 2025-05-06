// Manages adding/removing QR codes in Establishment create/edit forms

$(document).ready(function() {
    const qrcodeSelect = document.getElementById('qrcode-select');
    const addQrcodeBtn = document.getElementById('add-qrcode-btn');
    const linkedQrcodesList = document.getElementById('linked-qrcodes-list');
    const noQrcodesMessage = document.getElementById('no-qrcodes-message');

    // --- Modal Handling (for create form primarily) ---
    const removeQrCodeModalEl = document.getElementById('removeQrCodeModal');
    let removeQrCodeModal = null;
    if (typeof bootstrap !== 'undefined' && removeQrCodeModalEl) {
        removeQrCodeModal = new bootstrap.Modal(removeQrCodeModalEl);
    }
    const confirmRemoveQrCodeBtn = document.getElementById('confirm-remove-qrcode');
    const qrcodeTitleToRemoveSpan = document.getElementById('qrcode-title-to-remove');
    let qrcodeToRemoveData = {
        id: null,
        title: null,
        description: null,
        elementToRemove: null // Store the button element that triggered the modal
    };
    // ----------------------------------------------------

    // Function to add a QR Code to the linked list
    function addQrCodeToList() {
        if (!qrcodeSelect || !qrcodeSelect.value) {
            console.warn('QR Code select element not found or no value selected.');
            return;
        }

        const selectedOption = qrcodeSelect.options[qrcodeSelect.selectedIndex];
        const qrCodeId = selectedOption.value;
        const qrCodeTitle = selectedOption.getAttribute('data-title');
        const qrCodeDescription = selectedOption.getAttribute('data-description');

        // Prevent adding if already exists (safety check)
        if (document.getElementById(`linked-qrcode-${qrCodeId}`)) {
            console.warn(`QR Code #${qrCodeId} is already linked.`);
            return;
        }

        // Remove the 'no QR codes' message if it exists
        if (noQrcodesMessage && linkedQrcodesList) {
            const currentNoMessage = linkedQrcodesList.querySelector('#no-qrcodes-message');
            if (currentNoMessage) {
                currentNoMessage.remove();
            }
        }

        // Create the list item
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.id = `linked-qrcode-${qrCodeId}`;
        li.innerHTML = `
            <div>
                <input type="hidden" name="qr_codes[]" value="${qrCodeId}">
                <strong class="font-medium">${qrCodeTitle}</strong>
                <small class="text-muted text-sm d-block">${qrCodeDescription}</small>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger remove-qrcode" data-id="${qrCodeId}" data-title="${qrCodeTitle}" data-description="${qrCodeDescription}">
                <i class="fas fa-times"></i>
            </button>
        `;

        // Append to the list
        if (linkedQrcodesList) {
            linkedQrcodesList.appendChild(li);
        }

        // Add event listener to the new remove button
        li.querySelector('.remove-qrcode').addEventListener('click', handleRemoveClick);

        // Remove the option from the select
        qrcodeSelect.remove(qrcodeSelect.selectedIndex);

        // Reset select and potentially disable add button
        qrcodeSelect.value = '';
        updateAddButtonState();
    }

    // Function to handle the click on a remove button
    function handleRemoveClick(event) {
        const button = event.currentTarget;
        const id = button.dataset.id;
        const title = button.dataset.title;
        const description = button.dataset.description;

        // If modal exists (create view), show it
        if (removeQrCodeModal && qrcodeTitleToRemoveSpan) {
            qrcodeToRemoveData = { id, title, description, elementToRemove: button };
            qrcodeTitleToRemoveSpan.textContent = `#${id} - ${title}`;
            removeQrCodeModal.show();
        } else {
            // If no modal (edit view or modal failed), remove directly
            removeQrCodeFromList(id, title, description);
        }
    }

    // Function to actually remove the QR Code from the list and add it back to the select
    function removeQrCodeFromList(id, title, description) {
        // Remove the list item
        const listItem = document.getElementById(`linked-qrcode-${id}`);
        if (listItem) {
            listItem.remove();
        }

        // Add the option back to the select
        if (qrcodeSelect) {
            const option = document.createElement('option');
            option.value = id;
            option.dataset.title = title;
            option.dataset.description = description;
            option.textContent = `#${id} - ${title}`;
            // Insert sorted? For now, just append.
            qrcodeSelect.appendChild(option);
        }

        // Show 'no QR codes' message if the list is empty
        if (linkedQrcodesList && !linkedQrcodesList.querySelector('li:not(#no-qrcodes-message)')) {
            const noItemsLi = document.createElement('li');
            noItemsLi.className = 'list-group-item text-center py-4';
            noItemsLi.id = 'no-qrcodes-message';
            noItemsLi.innerHTML = `
                <div class="text-muted">
                    <i class="fas fa-info-circle me-2"></i> Nenhum QR Code vinculado a este estabelecimento.
                </div>
            `;
            linkedQrcodesList.appendChild(noItemsLi);
        }

        // Update the add button state
        updateAddButtonState();
    }

    // Function to enable/disable the add button based on available options
    function updateAddButtonState() {
        if (qrcodeSelect && addQrcodeBtn) {
            const hasOptions = qrcodeSelect.options.length > 1; // More than the placeholder
            qrcodeSelect.disabled = !hasOptions;
            addQrcodeBtn.disabled = !hasOptions;
        }
    }

    // --- Event Listeners Initialization ---

    // Add button
    if (addQrcodeBtn) {
        addQrcodeBtn.addEventListener('click', addQrCodeToList);
    }

    // Existing remove buttons (on page load for edit view)
    if (linkedQrcodesList) {
        linkedQrcodesList.querySelectorAll('.remove-qrcode').forEach(button => {
            button.addEventListener('click', handleRemoveClick);
        });
    }

    // Modal confirmation button
    if (confirmRemoveQrCodeBtn) {
        confirmRemoveQrCodeBtn.addEventListener('click', function() {
            if (qrcodeToRemoveData.id) {
                removeQrCodeFromList(
                    qrcodeToRemoveData.id,
                    qrcodeToRemoveData.title,
                    qrcodeToRemoveData.description
                );
            }
            if (removeQrCodeModal) {
                removeQrCodeModal.hide();
            }
            // Reset temporary data
            qrcodeToRemoveData = { id: null, title: null, description: null, elementToRemove: null };
        });
    }

    // Initial check for add button state
    updateAddButtonState();

});
