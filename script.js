
let selectedImage = document.querySelector('#selectedImage');
let choose_image = document.querySelector('.choose_image');

let image_holder = document.querySelector('.image_holder');
let image = document.querySelector('#image');

let slider = document.querySelectorAll('.slider');
let show_value = document.querySelectorAll('.show_value');

let list_options = document.querySelectorAll('ul li');

let options = document.querySelector('.options');
let option = document.querySelectorAll('.option');

let clearAll = document.querySelector('#clearAll');
let remove_img_btn = document.querySelector('#remove_img_btn');


let canvas = document.querySelector('#image_canvas');
const context = canvas.getContext('2d');

let File_Name;
let Edited = false;

/*sliderlarla resmin ayarlarını değiştirme*/
for (let i = 0; i <= slider.length - 1; i++) {
   slider[i].addEventListener('input', editImage);
}

function editImage() {
   let bright = document.querySelector('#brightness');
   let blur = document.querySelector('#blur');
   let grey = document.querySelector('#greyScale');
   let hue = document.querySelector('#hue');
   let saturation = document.querySelector('#saturation');


   let brightValShow = document.querySelector('#brightVal');
   let blurValShow = document.querySelector('#blurVal');
   let greyValShow = document.querySelector('#greyVal');
   let hueValShow = document.querySelector('#hueVal');
   let saturationValShow = document.querySelector('#saturationVal');

   let brightVal = bright.value;
   let greyVal = grey.value;
   let blurVal = blur.value;
   let hueVal = hue.value;
   let satuVal = saturation.value;

   brightValShow.innerHTML = brightVal;
   blurValShow.innerHTML = blurVal;
   greyValShow.innerHTML = greyVal;
   hueValShow.innerHTML = hueVal;
   saturationValShow.innerHTML = satuVal;

   image.style.filter = 'grayscale(' + greyVal + '%) hue-rotate(' + hueVal + 'deg) brightness(' + brightVal + '%) blur(' + blurVal + 'px) saturate(' + satuVal + ')';
   context.filter = 'grayscale(' + greyVal + '%) hue-rotate(' + hueVal + 'deg) brightness(' + brightVal + '%) blur(' + blurVal + 'px) saturate(' + satuVal + ')';

   clearAll.style.transform = 'translateY(0px)';
}


/*seçenekleri düzenleme*/
list_options.forEach((list_option, index) => {
   list_option.addEventListener('click', function () {


      if (image.getAttribute('src') == "") {
         alert("Choose Image First");
      } else {

         options.style.transform = 'translateY(0px)';

         if (Edited == true) {
            canvas.height = image.naturalHeight;
            canvas.width = image.naturalWidth;

            for (let i = 0; i <= 4; i++) {

               if (index != i) {
                  list_options[i].classList.remove("active_option");
                  option[i].classList.remove("active_controller");

               } else {
                  this.classList.add("active_option");
                  option[i].classList.add("active_controller");
               }
            }

         } else {
            alert("Edit Your Image First");
         }

      }

   })
})


/*indirme butonu*/
function Download_btn() {

   if (image.getAttribute('src') != "") {

      if (Edited == true) {
         context.drawImage(image, 0, 0, canvas.width, canvas.height);
         var jpegUrl = canvas.toDataURL("image/jpg");

         const link = document.createElement("a");
         document.body.appendChild(link);

         link.setAttribute("href", jpegUrl);
         link.setAttribute("download", File_Name);
         link.click();
         document.body.removeChild(link);

      }
   }
}


/*reset butonu*/
clearAll.addEventListener("click", function () {
   clearAllRangeValue();
})

function clearAllRangeValue() {
   image.style.filter = 'none';
   context.filter = 'none';

   for (let i = 0; i <= slider.length - 1; i++) {
      if (i == 0) {
         slider[i].value = '100';
      } else {
         slider[i].value = '0';
      }
   }

   editImage();
   clearAll.style.transform = 'translateY(150px)';
}

