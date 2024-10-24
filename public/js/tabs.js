document.addEventListener("DOMContentLoaded", function() {
    const tabs = document.querySelectorAll(".tab");
    const tabContents = document.querySelectorAll(".tab-content");

    tabs.forEach((tab, index) => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => {
                t.classList.remove("active");
                t.classList.remove("bg-blue-500");
                t.classList.add("bg-gray-200");
                t.classList.add("text-gray-700");
            });
            tabContents.forEach(tc => tc.classList.add("hidden"));

            tab.classList.add("active");
            tab.classList.add("bg-blue-500");
            tab.classList.add("text-white");
            tab.classList.remove("bg-gray-200");
            tab.classList.remove("text-gray-700");
            tabContents[index].classList.remove("hidden");
        });
    });
});
