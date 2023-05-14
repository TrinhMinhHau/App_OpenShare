const selectFile = function () {
  let regex = /[^\\]+$/;

  this.fileToUploadmul, this.selected;

  this.msg = (str) => {
    let prefix = "[selectFile.js]\n\nError: ";
    return alert(prefix + str);
  };

  this.check = () => {
    if (this.fileToUploadmul && this.selected != null) {
      let fileToUploadmul = document.getElementById(this.fileToUploadmul),
        selected = document.getElementById(this.selected);
      fileToUploadmul.addEventListener("change", () => {
        if (fileToUploadmul.value != "") {
          selected.innerHTML = fileToUploadmul.value.match(regex);
        }
      });
    } else {
      this.msg("Targets not set.");
    }
  };

  selectFile.prototype.targets = (trigger, filetext) => {
    this.fileToUploadmul = trigger;
    this.selected = filetext;
  };

  selectFile.prototype.simulate = () => {
    if (this.fileToUploadmul != null) {
      let fileToUploadmul = document.getElementById(this.fileToUploadmul);
      if (typeof fileToUploadmul != "undefined") {
        fileToUploadmul.click();
        this.check();
      } else {
        this.msg("Could not find element " + this.fileToUploadmul);
      }
    } else {
      this.msg("Targets not set.");
    }
  };
};
var getFile = new selectFile();
getFile.targets("fileToUploadmul", "selected");
