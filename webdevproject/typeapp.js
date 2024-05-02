const userinput = document.getElementById("user_input")
const text = document.getElementById("textt")
const timer = document.getElementById("timer")
const wpmtext = document.getElementById("wpm")
const acctext = document.getElementById("acc")

let firstpress = true
let endofgame = false
let counter = 0

let fincorrect = 0
let finkeypressed = 0

wpmtext.value = 0
acctext.value = 0

userinput.addEventListener("input", (event) => {
    const quotearray = text.querySelectorAll("span")
    const valuearray = userinput.value.split("")
    let correct = 0
    let keypressed = 0
    let clock
    if(firstpress){
        clock = setInterval(() => {
            wpmtext.value = 0
            acctext.value = 0
            counter++
            timer.innerHTML = counter
            if(counter == 30 || finkeypressed == text.innerText.length){
                clearInterval(clock)
                wpmtext.value = wpm(fincorrect, counter)
                acctext.value = acc(finkeypressed, fincorrect)
                timer.innerText = counter
                firstpress = true
                endofgame = true
                document.getElementById("wpmform").submit()
            }
        }, 1000);
        firstpress = false
    }
    quotearray.forEach((charspan, index) => {
        const char = valuearray[index]
        if (char == null){
            charspan.classList.remove("correct")
            charspan.classList.remove("incorrect")
        }
        else if(char == charspan.innerText){
            charspan.classList.add("correct")
            charspan.classList.remove("incorrect")
            correct++
            keypressed++
        }
        else {
            charspan.classList.add("incorrect")
            charspan.classList.remove("correct")
            keypressed++
        }
    })
    finkeypressed = keypressed
    fincorrect = correct
    
})

async function getquote(){
    try {
        let val = ""

        await fetch("quotes.json")
        .then(resolve => resolve.json())
        .then(data => {
            val = data[0].quotes[Math.floor(Math.random() * 12)]
        })
    
        newquote(val)
        userinput.value = ""

    }
    catch(error){
        console.log(error)
    }
}

function newquote(val){
    const quote = val
    text.innerHTML = ""
    quote.split("").forEach((char) => {
        const charspan = document.createElement("span")
        charspan.innerText = char
        text.appendChild(charspan)
    })
}

function wpm(keys, secs){
    return Math.round((keys / 5) / (secs / 60))
}

function acc(keys, corrkeys){
    return Math.round((corrkeys / keys) * 100)
}


getquote()