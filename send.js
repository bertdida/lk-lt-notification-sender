const fs = require("fs");
const axios = require("axios");

require("dotenv").config();

const filename = process.argv[2];
fs.readFile(filename, "utf8", async function (_, data) {
  const { HOST, PORT = 5000 } = process.env;
  const endpoint = `http://${HOST}:${PORT}/api/notification`;
  axios.post(endpoint, JSON.parse(data));
  fs.unlink(filename, () => {});
});