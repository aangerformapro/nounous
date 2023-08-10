import connectLiveReload from "connect-livereload";
import express from "express";
import livereload from "livereload";
import minimist from "minimist";
import path from "node:path";


const
    app = express(),
    argv = minimist(process.argv.slice(2), {
        boolean: [],
        alias: {
            'p': 'port',
            'r': 'root'
        },
        default: {
            port: 8000,
            root: 'public'
        }
    });

let { port, root } = argv;

const liveReloadServer = livereload.createServer();

liveReloadServer.watch(path.resolve(process.cwd(), root));

liveReloadServer.server.once("connection", () =>
{
    setTimeout(() =>
    {
        liveReloadServer.refresh("/");
    }, 100);
});


app.use(connectLiveReload());

app.use(express.static(root));

// insert routes there




// for spa uncomment this
// app.get('*', (req, res) =>
// {
//     res.sendFile(path.resolve(process.cwd(), "public", "index.html"));
// });

app.listen(port, () =>
{
    console.log(
        'Server ' +
        path.basename(path.resolve()) +
        ' listening on port ' + port,
        'http://localhost:' + port + '/'
    );
});
