"use strict";

// Bank Details Management
let addMoreBank=2;

function showUploadDocumentImage(input) {
    let files = input.files[0];
    let previewContainer = input.closest('.previewContainer');
    let imagePreview = previewContainer.querySelectorAll('.imagePreview')[0];
    let docPreview = previewContainer.querySelectorAll('.docPreview')[0];
    let iconPreview = previewContainer.querySelectorAll('.iconPreview')[0];
}

function addMoreBankDetails(e) {
    e.preventDefault();
    let newBankDetails = `
            <tr class="bankDetails_${addMoreBank}">
                <td >
                    <div class="btn btn-danger mt-1"><a type="button" id="nextButton" class="fa-solid fa-user-minus removeTr" onclick='removeTr(${addMoreBank})'></a><div>
                </td>
                <td><input type="text" name="bank_name[]" class="form-control" placeholder="Enter bank name"></td>
                <td><input type="text" name="branch_name[]" class="form-control" placeholder="Enter branch name"></td>
                <td><input type="text" name="account_holder_name[]" class="form-control" placeholder="Enter account holder name"></td>
                <td><input type="text" name="account_number[]" class="form-control" placeholder="Enter account number"></td>
                <td><input type="text" name="ifsc_code[]" class="form-control" placeholder="Enter IFSC code"></td>
                <td><input type="text" name="beneficiary_name[]" class="form-control" placeholder="Enter beneficiary name"></td>
                <td>
                    <input type="file" name="documents[]" class="form-control fileInput" onchange="showUploadDocumentImage(this)" placeholder="Upload document">
                    <div class="previewContainer" style="display: none;">
                        <img class="imagePreview" style="width: 100px; height: 100px; display: none;" />
                        <span onclick="removePreview(this)" style="position: absolute; top: -10px; right: -10px; cursor: pointer; background: red; color: white; border-radius: 50%; padding: 0 5px;">X</span>
                        <iframe class="docPreview" style="width: 100px; height: 100px; display: none;"></iframe>
                        <div class="iconPreview" style="width: 100px; height: 100px; text-align: center; line-height: 100px; border: 1px solid #ccc;">📄</div>
                    </div>
                </td>
            </tr>
    `;
    $('#bankDetailsTable tbody').append(newBankDetails);
    addMoreBank++;
    document.querySelectorAll('.removeTr').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('tr').remove();
        });
    });
}



// Attendence Management
document.querySelectorAll('input[name="choice"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {
        if (event.target.value === "punchValue1") {
            document.getElementById("content1").style.display = "block";
            document.getElementById("content2").style.display = "none";
        } else {
            document.getElementById("content1").style.display = "none";
            document.getElementById("content2").style.display = "block";
        }
    });
});


