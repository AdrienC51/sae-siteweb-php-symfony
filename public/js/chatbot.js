document.addEventListener("DOMContentLoaded", function () {
    const chatbox = document.getElementById("chatbox");
    const userInput = document.getElementById("user-input");
    const sendBtn = document.getElementById("send-btn");

    async function queryHuggingFace(input) {
        try {
            const response = await fetch(
                "https://api-inference.huggingface.co/models/distilbert/distilgpt2",
                {
                    headers: {
                        Authorization: "Bearer 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",
                        "Content-Type": "application/json",
                    },
                    method: "POST",
                    body: JSON.stringify({ inputs: input }),
                }
            );

            if (!response.ok) {
                throw new Error(`Erreur : ${response.status}`);
            }

            const data = await response.json();
            return data.length > 0 ? data[0]?.generated_text : "Pas de réponse.";
        } catch (error) {
            console.error("Erreur lors de la requête :", error);
            return "Une erreur est survenue. Réessayez plus tard.";
        }
    }

    function addMessage(content, className) {
        const message = document.createElement("div");
        message.className = `message ${className}`;
        message.textContent = content;
        chatbox.appendChild(message);
        chatbox.scrollTop = chatbox.scrollHeight;
    }

    sendBtn.addEventListener("click", async () => {
        const input = userInput.value.trim();
        if (!input) return;

        addMessage(input, "user");
        userInput.value = "";

        const botResponse = await queryHuggingFace(input);
        addMessage(botResponse, "bot");
    });
});
