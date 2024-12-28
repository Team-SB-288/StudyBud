document.addEventListener('DOMContentLoaded', function() {
    let profilePicInput = document.getElementById("select-pfp");
    let profilePicImg = document.getElementById("pfp");

    function updateProfilePic() {
        if (profilePicInput.files && profilePicInput.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = new Image();
                img.onload = function() {
                    let canvas = document.createElement('canvas');
                    let ctx = canvas.getContext('2d');
                    let size = Math.min(img.width, img.height);
                    canvas.width = canvas.height = size;
                    ctx.drawImage(img, (img.width - size) / 2, (img.height - size) / 2, size, size, 0, 0, size, size);
                    profilePicImg.src = canvas.toDataURL();
                    
                    // Update the file input with the cropped image
                    canvas.toBlob(function(blob) {
                        let file = new File([blob], profilePicInput.files[0].name, { type: 'image/png' });
                        let dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        profilePicInput.files = dataTransfer.files;
                    }, 'image/png');
                }
                img.src = e.target.result;
            }
            reader.readAsDataURL(profilePicInput.files[0]);
        }
    }

    if (profilePicInput) {
        profilePicInput.addEventListener('change', updateProfilePic);
    }
});