const express = require("express");
const app = express();
const mysql = require("mysql");
const cors = require("cors");

app.use(cors());
app.use(express.json());
const db = mysql.createConnection({
    host:"localhost",
    user:"root",
    password:"",
    database:"rainanectar"
});

app.post("/create",(req,res)=>{
    const Nombres = req.body.Nombres;
    const Apellidos = req.body.Apellidos;
    const Correo = req.body.Correo;
    const NombreUsuario = req.body.NombreUsuario;
    const Contrasena = req.body.Contrasena;
    const TipoDocumento = req.body.TipoDocumento;
    const Documento = req.body.Documento;
    const Rol = req.body.Rol;


    db.query('INSERT INTO usuarios(Nombres,Apellidos,Correo,NombreUsuario,Contrasena,TipoDocumento,Documento,Rol) VALUES(?,?,?,?,?,?,?,?)',[Nombres,Apellidos,Correo,NombreUsuario,Contrasena,TipoDocumento,Documento,Rol],
    (err,result)=>{
        if(err){
            console.log(err);
        }else{
            res.send("Empleado registrado con exito")
        }
    }
    );
});

app.listen(3001,()=>{
    console.log("Corriendo en el puerto 3001")
})