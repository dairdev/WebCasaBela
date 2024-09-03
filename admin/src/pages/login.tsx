import { useState } from 'preact/hooks'

export function Login(){
  const [form, setForm] = useState({ user: "", password: ""});

  const updateForm = (field: string, value: string) => {
    console.log(`Field: ${field} Value: ${value}`);
  };

  return (
  <>
      <div>
        <h1>Login</h1>
        <form>
          <fieldset>
            <label>Usuario</label>
            <input
              type="text"
              name="usuario"
              value={form.user}
              onChange={ e => updateForm("user", e.target.value) } 
              required
            />
          </fieldset>
          <fieldset>
            <label>Contraseña</label>
            <input
              type="password"
              name="password"
              value={form.password}
              onChange={ e => updateForm("password", e.target.value) } 
              required
            />
          </fieldset>
        </form>
      </div>
    </>
  );
}
