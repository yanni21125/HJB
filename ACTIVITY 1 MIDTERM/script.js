function generateGreeting(name, age) {
    let status;

    if (age < 18) {
        status = "You are a minor.";
    } else {
        status = "You are an adult.";
    }

    return Hello, ${name}! ${status};
}

function displayGreeting() {
    const name = document.getElementById("name").value;
    const age = Number(document.getElementById("age").value);
    const result = document.getElementById("result");

    if (name === "" || age === 0) {
        result.textContent = "Please enter your name and age.";
        return;
    }

    result.textContent = generateGreeting(name, age);
}
