import { render } from "preact";
import { Router, Route, route } from "preact-router";
import { ThemeProvider, createTheme } from "@mui/material/styles";
import CssBaseline from "@mui/material/CssBaseline";
import { useState, useEffect } from "preact/hooks";
import Login from "./pages/Login";
import AdminLayout from "./layouts/AdminLayout";
import Properties from "./pages/Admin/Properties";
import Clients from "./pages/Admin/Clients";
import Appointments from "./pages/Admin/Appointments";
import Users from "./pages/Admin/Users";
import NotFound from "./pages/NotFound";

const theme = createTheme({
	palette: {
		mode: "light",
		primary: {
			main: "#1976d2",
		},
		secondary: {
			main: "#dc004e",
		},
	},
});

export function App() {
	const [isAuthenticated, setIsAuthenticated] = useState(false);

	useEffect(() => {
		// Check if user is authenticated (e.g., check localStorage for token)
		const token = localStorage.getItem("authToken");
		setIsAuthenticated(!!token);
	}, []);

	const handleLogin = () => {
		setIsAuthenticated(true);
		route("/admin/properties");
	};

	const handleLogout = () => {
		localStorage.removeItem("authToken");
		setIsAuthenticated(false);
		route("/login");
	};

	return (
		<ThemeProvider theme={theme}>
			<CssBaseline />
			<Router>
				<Route
					path="/login"
					component={() => <Login onLogin={handleLogin} />}
				/>
				<Route
					path="/admin/:page?"
					component={({ page }: { page?: string }) =>
						isAuthenticated ? (
							<AdminLayout onLogout={handleLogout}>
								{renderAdminPage(page || "properties")}
							</AdminLayout>
						) : (
							<Login onLogin={handleLogin} />
						)
					}
				/>
				<Route
					default
					component={() =>
						isAuthenticated ? <Properties /> : <Login onLogin={handleLogin} />
					}
				/>
				<Route path="/404" component={NotFound} />
			</Router>
		</ThemeProvider>
	);
}

function renderAdminPage(page: string) {
	switch (page) {
		case "properties":
			return <Properties />;
		case "clients":
			return <Clients />;
		case "appointments":
			return <Appointments />;
		case "users":
			return <Users />;
		default:
			return <Properties />;
	}
}

render(<App />, document.getElementById("app")!);
