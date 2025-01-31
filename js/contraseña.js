document.addEventListener("DOMContentLoaded", () => {
    // Primer campo de contraseña
    const pass1 = document.getElementById("login_password");
    const icon1 = document.querySelector(".password-container i"); // Cambiar selección

    if (icon1) {
        icon1.addEventListener("click", () => {
            pass1.type = pass1.type === "password" ? "text" : "password"; // Cambia el tipo
        });
    }

    // Segundo campo de contraseña
    const pass2 = document.getElementById("password");
    const icon2 = document.querySelectorAll(".password-container i")[1]; // Cambiar selección

    if (icon2) {
        icon2.addEventListener("click", () => {
            pass2.type = pass2.type === "password" ? "text" : "password"; // Cambia el tipo
        });
    }

    // Manejo de fuerza de contraseña
    const passwordStrength = document.getElementById("password-strength");
    const passwordMessage = document.getElementById("password-message");

    pass2.addEventListener("input", function() {
        const value = pass2.value;
        let strength = 0;

        if (value.length >= 8) strength++;
        if (/[A-Z]/.test(value)) strength++;
        if (/[a-z]/.test(value)) strength++;
        if (/\d/.test(value)) strength++;
        if (/[!@#$%^&*(),.?":{}|<>]/.test(value)) strength++;

        if (strength === 0) {
            passwordStrength.style.backgroundColor = "transparent";
            passwordMessage.textContent = "";
        } else if (strength < 3) {
            passwordStrength.style.backgroundColor = "red";
            passwordMessage.textContent = "Contraseña insegura.";
        } else if (strength < 5) {
            passwordStrength.style.backgroundColor = "blue";
            passwordMessage.textContent = "Contraseña medio segura.";
        } else {
            passwordStrength.style.backgroundColor = "green";
            passwordMessage.textContent = "Contraseña segura.";
        }
    });

    // Manejo de rol
    const rolSelect = document.getElementById("rol");
    const adminOption = rolSelect.querySelector('option[value="2"]');
    if (adminOption) {
        adminOption.remove(); // Eliminar la opción de Administrador
    }
});