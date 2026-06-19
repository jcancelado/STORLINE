
import './App.css';
import { useState } from 'react';
import Axios from "axios";
import 'bootstrap/dist/css/bootstrap.min.css';
import Swal from 'sweetalert2'

function App() {

  const[UsuarioID,setUsuarioID] = useState("");

  const[Nombres,setNombres] = useState("");
  const[Apellidos,setApellidos] = useState("");
  const[Correo,setCorreo] = useState("");
  const[NombreUsuario,setNombreUsuario] = useState("");
  const[Contrasena,setContrasena] = useState("");
  const[Rol,setRol] = useState(0);
  const[TipoDocumento,setTipoDocumento] = useState(0);
  const[Documento,setDocumento] = useState("");
  const[editar,seteditar] = useState(false);

const [usuariosLista, setUsuarios] = useState([]);

const add = async () => {
  try {
    await Axios.post("http://localhost:3001/create", {
      UsuarioID,
      Nombres,
      Apellidos,
      Correo,
      NombreUsuario,
      Contrasena,
      TipoDocumento,
      Documento,
      Rol,
    });

    getUsuarios();
limpiarCmpos();
Swal.fire({
  title: "<strong>Registro exitoso</strong>",
  html:"<i>El usuario <strong>"+NombreUsuario+ "</strong>fue registrado</i>",
  icon: 'succes',
  timer:3000
})
  } catch (error) {
    console.error("Error al registrar usuario:", error.message);
    alert("Hubo un error al registrar el usuario");
  }
};
const update = () => {
  Axios.put("http://localhost:3001/update", {
    UsuarioID: UsuarioID,
    Nombres: Nombres,
    Apellidos: Apellidos,
    Correo: Correo,
    NombreUsuario: NombreUsuario,
    Contrasena: Contrasena,
    TipoDocumento: TipoDocumento,
    Documento: Documento,
    Rol: Rol,
  })
    .then(() => {
      getUsuarios();
      Swal.fire({
        title: "<strong>Actualizacion del usuario exitoso</strong>",
        html:"<i>El usuario <strong>"+NombreUsuario+ "</strong>fue actualizado</i>",
        icon: 'succes',
        timer:3000
      })    });
    
};

const deleteUsuario = (val) => {

  Swal.fire({
    title: "¿Confirmar eliminado",
    html:"<i>¿Realmente desea eliminiar al usuario <strong>"+val.NombreUsuario+ "</strong>?</i>",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Si, eliminar!"
  }).then((result) => {
    if (result.isConfirmed) {
      
  Axios.delete(`http://localhost:3001/delete/${val.UsuarioID}`).then(() => {
    getUsuarios();
    limpiarCmpos();
    Swal.fire({
      position: "top-end",
      icon: "success",
      title: val.nombre+" fue eliminado.",
      showConfirmButton: false,
      timer: 2000}
   );
   });
      
    }
  });
 
    
};

const limpiarCmpos =()=>{
  seteditar(false);
  setNombres("");
  setApellidos("");
  setCorreo("");
  setNombreUsuario("");
  setContrasena("");
  setTipoDocumento("");
  setDocumento("");
  setRol("");
}

const editarUsuario = (val)=>{
seteditar(true);

setNombres(val.Nombres);
setApellidos(val.Apellidos);
setCorreo(val.Correo);
setNombreUsuario(val.NombreUsuario);
setContrasena(val.Contrasena);
setTipoDocumento(val.TipoDocumento);
setDocumento(val.Documento);
setRol(val.Rol);
setUsuarioID(val.UsuarioID);

}
const getUsuarios = ()=>{
  Axios.get("http://localhost:3001/usuarios")
  .then((response) => {
    setUsuarios(response.data);
  })
  .catch(() => {
  });
}

getUsuarios();

  return ( <div className="container">
    
    <div className="card text-center">
    <div className="card-header">
      GESTION DE USUARIOS
    </div>
    <div className="card-body">
      <div className="input-group mb-3">
        <span className="input-group-text" id="basic-addon1">Nombres</span>
        <input type="text" value={Nombres}
         onChange={(event)=>{
          setNombres(event.target.value)
        }}
        className="form-control" placeholder="Ingrese los nombres" aria-label="Username" aria-describedby="basic-addon1"/>
      </div>
    
      <div className="input-group mb-3">
        <span className="input-group-text" id="basic-addon1">Apellidos</span>
        <input type="text" value={Apellidos}
         onChange={(event)=>{
          setApellidos(event.target.value)
        }}
        className="form-control" placeholder="Ingrese los apellidos" aria-label="Username" aria-describedby="basic-addon1"/>
      </div>
      <div className="input-group mb-3">
        <span className="input-group-text" id="basic-addon1">Correo</span>
        <input type="text" value={Correo}
         onChange={(event)=>{
          setCorreo(event.target.value)
        }}
        className="form-control" placeholder="Ingrese el correo" aria-label="Username" aria-describedby="basic-addon1"/>
      </div>
      <div className="input-group mb-3">
        <span className="input-group-text" id="basic-addon1">Nombre de Usuario</span>
        <input type="text" value={NombreUsuario}
         onChange={(event)=>{
          setNombreUsuario(event.target.value)
        }}
        className="form-control" placeholder="Ingrese el nombre de usuario" aria-label="Username" aria-describedby="basic-addon1"/>
      </div>
      <div className="input-group mb-3">
      <span className="input-group-text" id="basic-addon1">Contraseña</span>
      {editar ? (
        <input
          type="password"
          value={Contrasena}
          onChange={(event) => setContrasena(event.target.value)}
          className="form-control"
          placeholder="Ingrese la contraseña"
          aria-label="Contraseña"
          aria-describedby="basic-addon1"
          readOnly
        />
      ) : (
        <input
          type="text"
          value={Contrasena}
          onChange={(event) => setContrasena(event.target.value)}
          className="form-control"
          placeholder="Ingrese la contraseña"
          aria-label="Username"
          aria-describedby="basic-addon1"
        />
      )}
    </div>

      <div className="input-group mb-3">
      <label className="input-group-text" htmlFor="tipoDocumentoSelect">Tipo de documento</label>
      <select
        className="form-control"
        id="TipoDocumentoSelect"
        value={TipoDocumento}
        onChange={(event) => setTipoDocumento(parseInt(event.target.value, 10))}
      >
        <option>Ingrese el tipo de documento</option>
        <option value={1}>Cédula de Ciudadanía</option>
        <option value={2}>Tarjeta de Identidad</option>
      </select>
    </div>

      <div className="input-group mb-3">
        <span className="input-group-text" id="basic-addon1">Documento</span>
        <input type="text" value={Documento}
         onChange={(event)=>{
          setDocumento(event.target.value)
        }}
        className="form-control" placeholder="Ingrese el numero de documento" aria-label="Username" aria-describedby="basic-addon1"/>
      </div>
      <div className="input-group mb-3">
      <label className="input-group-text" htmlFor="rolSelect">Rol</label>
      <select
        className="form-control"
        id="rolSelect"
        value={Rol}
        onChange={(event) => setRol(parseInt(event.target.value, 10))}
      >
        <option>Ingrese el rol</option>
        <option value={1}>Usuario</option>
        <option value={2}>Administrador</option>
      </select>
    </div>
      
     </div>
    <div className="card-footer text-muted">

      {
        editar?
        <div>
        <button className='btn btn-warning m-2' onClick={update}>Actualizar</button>
        <button className='btn btn-info m-2' onClick={limpiarCmpos}>Cancelar</button>
        </div>
        :<button className='btn btn-success' onClick={add}>Registrar</button>

      }

    </div>
</div>

<table className="table table-striped table-hover">
<thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Correo</th>
      <th scope="col">Nombre de usuario</th>
      <th scope="col">Contraseña</th>
      <th scope="col">Tipo de documento</th>
      <th scope="col">Documento</th>
      <th scope="col">Rol</th>
      <th scope="col">Acciones</th>



    </tr>
  </thead>
  <tbody>
  {
       usuariosLista.map((val, key) => (
        <tr key={val.UsuarioID}>
          <th>{val.UsuarioID}</th>
          <td>{val.Nombres}</td>
          <td>{val.Apellidos}</td>
          <td>{val.Correo}</td>
          <td>{val.NombreUsuario}</td>
          <td>{val.Contrasena}</td>
          <td>{val.TipoDocumento}</td>
          <td>{val.Documento}</td>
          <td>{val.Rol}</td>
          <td>
            <div className="btn-group" role="group" aria-label="Basic example">
              <button
                type="button"
                onClick={() => {
                  editarUsuario(val);
                }}
                className="btn btn-info"
              >
                Editar
              </button>
              <button type="button" 
              onClick={()=>{
                deleteUsuario(val);
              }}
              className="btn btn-danger">
                Eliminar
              </button>
            </div>
          </td>
        </tr>
      ))
}
   
  </tbody>
</table>
    </div>
  );

}
export default App;
