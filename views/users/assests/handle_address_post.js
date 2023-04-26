const host1 = "https://provinces.open-api.vn/api/";
var callAPI = (api) => {
  return axios.get(api).then((response) => {
    renderData(response.data, "province_post");
  });
};
callAPI("https://provinces.open-api.vn/api/?depth=1");
var callApiDistrict = (api) => {
  return axios.get(api).then((response) => {
    renderData(response.data.districts, "district_post");
  });
};
var callApiWard = (api) => {
  return axios.get(api).then((response) => {
    renderData(response.data.wards, "ward_post");
  });
};

var renderData = (array, select) => {
  let row = ' <option disable value="">chọn</option>';
  array.forEach((element) => {
    row += `<option value="${element.code}">${element.name}</option>`;
  });
  document.querySelector("#" + select).innerHTML = row;
};
console.log(renderData);
$("#province_post").change(() => {
  callApiDistrict(host1 + "p/" + $("#province_post").val() + "?depth=2");
  printResult();
});
$("#district_post").change(() => {
  callApiWard(host1 + "d/" + $("#district_post").val() + "?depth=2");
  printResult();
});
$("#ward_post").change(() => {
  printResult();
});
$("#street_post").on("input", () => {
  printResult();
});
var printResult = () => {
  if (
    $("#district_post").val() != "" &&
    $("#province_post").val() != "" &&
    $("#ward_post").val() != "" &&
    $("#street_post").val() != ""
  ) {
    let result =
      $("#province_post option:selected").text() +
      "," +
      $("#district_post option:selected").text() +
      "," +
      $("#ward_post option:selected").text() +
      "," +
      $("#street_post").val();
    $("#result_post").val(result); // Set the value of the result-input field
  }
};
