import { render } from 'preact'
import { App } from './app.tsx'
import { Login } from './pages/login.tsx'
import './index.css'

render(<Login />, document.getElementById('app')!)
