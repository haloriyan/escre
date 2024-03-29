const select = dom => document.querySelector(dom)
const selectAll = dom => document.querySelectorAll(dom)

const scrollKe = dom => {
    select(dom).scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

const post = (url, data) => {
    return fetch(url, {
        method: 'POST',
        headers: {
            "X-CSRF-TOKEN": data.csrfToken,
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
}
const get = url => {
    return fetch(url)
    .then(res => res.json())
}

const bindDivWithImage = () => {
    const divsWithBgImg = selectAll("div[bg-image]")
    divsWithBgImg.forEach(div => {
        let bg = div.getAttribute('bg-image')
        div.style.backgroundImage = `url('${bg}')`
        div.style.backgroundPosition = 'center center'
        div.style.backgroundSize = 'cover'
    })
}
bindDivWithImage()

// alert
let alerts = selectAll('.alert .ke-kanan')
alerts.forEach(alert => {
    alert.addEventListener('click', e => {
        let parent = e.currentTarget.parentNode
        parent.style.display = "none"
    })
})

const munculPopup = sel => {
    let popup = select(sel)
    select(".bg").style.display = "block"
    popup.style.display = "block"
    // let height = popup.clientHeight
    // popup.style.marginTop = `${height}px`
    setTimeout(() => {
        select(sel + " .popup").style.top = "70px"
    }, 50)
}
const hilangPopup = (sel) => {
    select(".bg").style.display = "none"
    selectAll(sel + " .popup").forEach(res => {
        // let height = res.clientHeight + 1250
        // res.style.marginTop = `-${height}px`
    })
    // setTimeout(() => {
        selectAll(sel).forEach(res => res.style.display = "none")
    // }, 100);
}
if (select(".bg")) {
    select(".bg").addEventListener('click', e => {
        hilangPopup(".popupWrapper")
    })
}

function htmlDecode(input){
    var e = document.createElement('textarea');
    e.innerHTML = input;
    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
}
function createElement(props) {  
    selectAll(props.createTo).forEach(target => {
        let el = document.createElement(props.el)
        if (props.attributes !== undefined) {
            props.attributes.forEach(res => {
                el.setAttribute(res[0], res[1])
            });
        }
        if(props.html !== undefined) {
            el.innerHTML = props.html;
        }
        target.appendChild(el);
        if (props.debug == true) {
            console.log(props);
            console.log(target);
        }
    });
}

function toIdr(angka) {
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return 'Rp '+rupiah.split('',rupiah.length-1).reverse().join('');
}
function toAngka(rupiah) {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}
function inArray(needle, haystack) {
    let length = haystack.length;
    for (let i = 0; i < length; i++) {
        if (haystack[i] == needle) return true;
    }
    return false;
}
const searchArrayIndex = (toSearch, datas) => {
    let i = 0;
    let key = Object.keys(toSearch);
    let value = toSearch[key];
    let toReturn = null;

    datas.forEach(data => {
        let iPP = i++;
        if (data[key] === value) {
            toReturn = iPP;
        }
    });

    return toReturn;
}

const redirect = url => {
    let a = document.createElement('a')
    a.href = url
    a.setAttribute('target', '_blank')
    a.click()
}
const sum = (...args) => {
    return args.reduce((total, arg) => total + arg, 0)
}

document.addEventListener('keydown', e => {
    if (e.key == "Escape") {
        hilangPopup(".popupWrapper")
    }
})

selectAll(".box").forEach(input => {
    input.setAttribute('autocomplete', 'off');
});

const inputFile = (input, previewArea) => {
    let file = input.files[0];
    let reader = new FileReader();
    let preview = select(previewArea);
    reader.readAsDataURL(file);

    reader.addEventListener("load", function() {
        // preview.style.width = "100%";
        preview.setAttribute('bg-image', reader.result);
        preview.innerHTML = "&nbsp;";
        bindDivWithImage();
    });
}

const removeArray = (toRemove, arr) => {
    let index = arr.indexOf(toRemove);
    arr.splice(index, 1);
}

function urlB64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

const copyText = (txt, callback = null) => {
    if (callback == null) {
        callback = console.log('Text copied');
    }
    navigator.clipboard.writeText(txt).then(callback);
}