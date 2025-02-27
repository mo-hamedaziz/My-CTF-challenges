const net = require("net");
const visit = require("./bot");
const dns = require("dns/promises");

const PORT = process.env.PORT || 8024;
const REPORT_HOST = process.env.REPORT_HOST || "localhost";

dns.lookup(REPORT_HOST).then(({ address }) => {
  const server = net.createServer(async (socket) => {
    if (!socket.remoteAddress.endsWith(address)) {
      socket.end("Bad reporting host");
      return;
    }
    socket.on("data", async (data) => {
      try {
        const url = data.toString().trim();
        socket.end("URL received");
        socket.destroy();

        if (!url.match(/^http:\/\//)) {
          console.log(`[-] Invalid URL: ${url}`);
          return;
        }

        console.log(`[+] Received: ${url}`);
        await visit(url);
        console.log(`[+] Visited: ${url}`);
      } catch (e) {
        console.log(e);
      }
    });
  });
  server.listen(PORT, () => {
    console.log("Bot socket server listening on port", PORT);
  });
});
