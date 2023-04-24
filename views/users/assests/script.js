const settingsMenuEL = document.querySelector(".settings-menu");
const settingnoticeEl = document.querySelector(".settings-notice");
const usserClicknoticeEl = document.querySelector(".notice-click");

const userClickEl = document.getElementById("userClick");
const darkbtnEl = document.getElementById("dark-btn");
userClickEl.addEventListener("click", handlerClickUser);
function handlerClickUser() {
  settingsMenuEL.classList.toggle("settings-menu-height");
}
usserClicknoticeEl.addEventListener("click", handlerClickNotice);
function handlerClickNotice() {
  settingnoticeEl.classList.toggle("settings-menu-height");
  console.log(1);
}

darkbtnEl.onclick = function () {
  darkbtnEl.classList.toggle("dark-btn-on");
  document.querySelector("body").classList.toggle("dark-theme");
  if (localStorage.getItem("theme") == "light") {
    localStorage.setItem("theme", "dark");
  } else {
    localStorage.setItem("theme", "light");
  }
};

if (localStorage.getItem("theme") == "light") {
  darkbtnEl.classList.remove("dark-btn-on");
  document.querySelector("body").classList.remove("dark-theme");
} else if (localStorage.getItem("theme") == "dark") {
  darkbtnEl.classList.add("dark-btn-on");
  document.querySelector("body").classList.add("dark-theme");
} else {
  localStorage.setItem("theme", "light");
}
