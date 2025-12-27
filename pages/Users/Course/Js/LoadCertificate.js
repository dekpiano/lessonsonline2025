
const BtnPDF = document.querySelector("#BtnPDF");
BtnPDF.addEventListener('click', function (e) {
    e.preventDefault();

    pdfMake.fonts = {
        THSarabunNew: {
            normal: 'https://isuchart.github.io/font/THSarabunNew.ttf',
        }
    }
    
    var doc = {
        content:[
            {text:'เด็กเปียโน'},
            {
                image:'https://picsum.photos/seed/picsum/200/300',
            }
        ],
        defaultStyle: {
            font: 'THSarabunNew',
            fontSize: 16,
         }
    }

    
     
    pdfMake.createPdf(doc).download();
})
