const express = require("express");
const app = express();
const mysql = require("mysql");
const cors = require("cors");
const bcryptjs = require("bcryptjs"); // Importa la librería bcrypt

app.use(cors());
app.use(express.json());
const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "rainanectar"
});

app.post("/create", (req, res) => {
    const Nombres = req.body.Nombres;
    const Apellidos = req.body.Apellidos;
    const Correo = req.body.Correo;
    const NombreUsuario = req.body.NombreUsuario;
    const Contrasena = req.body.Contrasena;
    const TipoDocumento = req.body.TipoDocumento;
    const Documento = req.body.Documento;
    const Rol = req.body.Rol;

    // Utiliza bcrypt para hashear la contraseña
    bcryptjs.hash(Contrasena, 10, (err, hash) => {
        if (err) {
            console.log(err);
            res.status(500).send("Error interno del servidor");
            return;
        }

        db.query('INSERT INTO usuarios(Nombres,Apellidos,Correo,NombreUsuario,Contrasena,TipoDocumento,Documento,Rol) VALUES(?,?,?,?,?,?,?,?)', [Nombres, Apellidos, Correo, NombreUsuario, hash, TipoDocumento, Documento, Rol],
            (err,result) => {
                if (err) {
                    console.log(err);
                    res.status(500).send("Error interno del servidor");
                } else {
                    res.send(result);
                }
            }
        );
    });
});

app.get("/usuarios", (req, res) => {
        db.query('SELECT * FROM usuarios',
            (err,result) => {
                if (err) {
                    console.log(err);
                } else {
                    res.send(result);
                }
            }
        );
    });
    app.put("/update", (req, res) => {
        const UsuarioID = req.body.UsuarioID;
        const Nombres = req.body.Nombres;
        const Apellidos = req.body.Apellidos;
        const Correo = req.body.Correo;
        const NombreUsuario = req.body.NombreUsuario;
        const Contrasena = req.body.Contrasena;
        const TipoDocumento = req.body.TipoDocumento;
        const Documento = req.body.Documento;
        const Rol = req.body.Rol;
    
        db.query( 'UPDATE usuarios SET Nombres=?, Apellidos=?, Correo=?, NombreUsuario=?, Contrasena=?, TipoDocumento=?, Documento=?, Rol=? WHERE UsuarioID=?',[Nombres, Apellidos, Correo, NombreUsuario, Contrasena, TipoDocumento, Documento, Rol, UsuarioID],
            (err,result) => {
                if (err) {
                    console.error(err);
                    res.status(500).send("Error interno del servidor");
                } else {
                    res.send(result);
                }
            }
        );
    });
    
    app.delete("/delete/:UsuarioID", (req, res) => {
        const UsuarioID = req.params.UsuarioID;
    
        db.query( 'DELETE FROM usuarios WHERE UsuarioID=?',UsuarioID,
            (err,result) => {
                if (err) {
                    console.error(err);
                    res.status(500).send("Error interno del servidor");
                } else {
                    res.send(result);
                }
            }
        );
    });
    
    



app.listen(3001, () => {
    console.log("Corriendo en el puerto 3001");
});
