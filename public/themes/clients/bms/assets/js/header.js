//  var slideIndex = 1;
//          showSlides(slideIndex);
         
//          function plusSlides(n) {
//            showSlides(slideIndex += n);
//          }
         
//          function currentSlide(n) {
//            showSlides(slideIndex = n);
//          }
         
//          function showSlides(n) {
//            var i;
//            var slides = document.getElementsByClassName("mySlides");
           
//            if (n > slides.length) {slideIndex = 1}    
//            if (n < 1) {slideIndex = slides.length}
//            for (i = 0; i < slides.length; i++) {
//                slides[i].style.display = "none";  
//            }
//            slides[slideIndex-1].style.display = "block";  
          
//          }


window.onscroll = function() {scrollFunction()};

function scrollFunction() {
if (document.body.scrollTop > 70 || document.documentElement.scrollTop > 70 && window.innerWidth > 992) {
  $("#header-menu").addClass('header-menu');        
}
  else {
    $("#header-menu").removeClass('header-menu');
}
  

}

// // arr demo
// let arr = ["anagrams-of-string-(with-duplicates)", "array-concatenation", "array-difference", "array-includes", "array-intersection", "array-remove", "array-sample", "array-union", "array-without", "array-zip", "average-of-array-of-numbers", "bottom-visible", "capitalize-first-letter-of-every-word", "capitalize-first-letter", "chain-asynchronous-functions", "check-for-palindrome", "chunk-array", "collatz-algorithm", "compact", "count-occurrences-of-a-value-in-array", "current-URL", "curry", "deep-flatten-array", "distance-between-two-points", "divisible-by-number", "drop-elements-in-array", "element-is-visible-in-viewport", "escape-regular-expression", "even-or-odd-number", "factorial", "fibonacci-array-generator", "fill-array", "filter-out-non-unique-values-in-an-array", "flatten-array-up-to-depth", "flatten-array", "get-days-difference-between-dates", "get-max-value-from-array", "get-min-value-from-array", "get-native-type-of-value", "get-scroll-position", "greatest-common-divisor-(GCD)", "group-by", "hamming-distance", "head-of-list", "hexcode-to-RGB", "initial-of-list", "initialize-array-with-range", "initialize-array-with-values", "is-array", "is-boolean", "is-function", "is-number", "is-string", "is-symbol", "last-of-list", "measure-time-taken-by-function", "median-of-array-of-numbers", "nth-element-of-array", "number-to-array-of-digits", "object-from-key-value-pairs", "object-to-key-value-pairs", "ordinal-suffix-of-number", "percentile", "pick", "pipe", "powerset", "promisify", "random-integer-in-range", "random-number-in-range", "redirect-to-URL", "reverse-a-string", "RGB-to-hexadecimal", "round-number-to-n-digits", "run-promises-in-series", "scroll-to-top", "shallow-clone-object", "shuffle-array", "similarity-between-arrays", "sleep", "sort-characters-in-string-(alphabetical)", "speech-synthesis-(experimental)", "standard-deviation", "sum-of-array-of-numbers", "swap-values-of-two-variables", "tail-of-list", "take-right", "take", "truncate-a-string", "unique-values-of-array", "URL-parameters", "UUID-generator", "validate-email", "validate-number", "value-or-default", "write-json-to-file"]

//       const updateResult = query => {
//         let listResult = document.querySelector('.list-result');
//         let resultList = document.querySelector(".result");

//         listResult.style.display = "block";
//         resultList.innerHTML = "";

//         arr.map(result =>{
//           query.split(" ").map(word =>{
//             if(result.toLowerCase().indexOf(word.toLowerCase()) != -1){
//               resultList.innerHTML += `<li class="list-group-item">${result}</li>`;
//             }
//           })
//         })
//       }

//   // updateResult("")

// function out(){
//   let listResult = document.querySelector('.list-result');
//     listResult.style.display = "none";
// }