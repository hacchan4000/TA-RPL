const elemenBlnThn = document.getElementById('blnThn');
const elemenHari = document.getElementById('dates');
const tmblPrev = document.getElementById('tmbl-prev');
const tmblNext = document.getElementById('tmbl-next');

let hariIni = new Date();

const updateKalender = () => {
    const thnSkrg = hariIni.getFullYear();
    const blnSkrg = hariIni.getMonth();

    const hPertama = new Date(thnSkrg,blnSkrg,0);
    const hTerakhir = new Date(thnSkrg,blnSkrg+1,0);
    const hTotal = hTerakhir.getDate();
    const indexHFirst = hPertama.getDay();
    const indexHLast = hTerakhir.getDay();

    const strBlnThn = hariIni.toLocaleString('default', {month: 'long', year: 'numeric'});
    elemenBlnThn.textContent = strBlnThn;

    let datesHTML = '';

    for (let i = indexHFirst; i > 0; i--) {
        const hariSblm = new Date(thnSkrg,blnSkrg, 0 - i + 1 );
        datesHTML += `<div class="hari tidak-aktif">${hariSblm.getDate()}</div>`;
    }

    for (let i = 0; i <= hTotal; i++) {
        const date = new Date(thnSkrg,blnSkrg, i);
        const classAktif = date.toDateString() === new Date().toDateString() ? 'aktif' : '';
        datesHTML += `<div class="hari ${classAktif}">${i}</div>`;
    }

    for (let i = 0; i <= 7 - indexHLast; i++) {
        const hariNext = new Date(thnSkrg,blnSkrg+1,i);
        datesHTML += `<div class="hari tidak-aktif">${hariNext.getDate()}</div>`;
    }

    elemenHari.innerHTML = datesHTML;
}

tmblPrev.addEventListener('click', ()=>{
    hariIni.setMonth(hariIni.getMonth()-1);
    updateKalender();
})
tmblNext .addEventListener('click', ()=>{
    hariIni.setMonth(hariIni.getMonth()+1);
    updateKalender();
})

updateKalender();