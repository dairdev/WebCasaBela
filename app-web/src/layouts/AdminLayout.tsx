import {
	AppBar,
	Toolbar,
	Typography,
	Drawer,
	List,
	ListItem,
	ListItemButton,
	ListItemIcon,
	ListItemText,
	Box,
	IconButton,
} from "@mui/material";
import {
	Home,
	People,
	Event,
	PersonAdd,
	ExitToApp,
	Menu,
} from "@mui/icons-material";
import { useState } from "preact/hooks";
import { route } from "preact-router";
import { ReactNode } from "preact/compat";
import casbelaLogo from "../assets/logo.svg";

const drawerWidth = 240;

interface AdminLayoutProps {
	children: ReactNode;
	onLogout: () => void;
}

const menuItems = [
	{ text: "Propiedades", icon: <Home />, path: "/admin/properties" },
	{ text: "Clientes", icon: <People />, path: "/admin/clients" },
	{ text: "Citas", icon: <Event />, path: "/admin/appointments" },
	{ text: "Usuarios", icon: <PersonAdd />, path: "/admin/users" },
];

export default function AdminLayout({ children, onLogout }: AdminLayoutProps) {
	const [mobileOpen, setMobileOpen] = useState(false);

	const handleDrawerToggle = () => {
		setMobileOpen(!mobileOpen);
	};

	const drawer = (
		<div>
			<img src={casbelaLogo} alt="Preact logo" height="160" width="160" />
			<List>
				{menuItems.map((item) => (
					<ListItem key={item.text} onClick={() => route(item.path)}>
						<ListItemButton>
							<ListItemIcon>{item.icon}</ListItemIcon>
							<ListItemText primary={item.text} />
						</ListItemButton>
					</ListItem>
				))}
				<ListItem onClick={onLogout}>
					<ListItemButton>
						<ListItemIcon>
							<ExitToApp />
						</ListItemIcon>
						<ListItemText primary="Logout" />
					</ListItemButton>
				</ListItem>
			</List>
		</div>
	);

	return (
		<Box sx={{ display: "flex" }}>
			<AppBar
				position="fixed"
				sx={{
					width: { sm: `calc(100% - ${drawerWidth}px)` },
					ml: { sm: `${drawerWidth}px` },
				}}
			>
				<Toolbar>
					<IconButton
						color="inherit"
						aria-label="open drawer"
						edge="start"
						onClick={handleDrawerToggle}
						sx={{ mr: 2, display: { sm: "none" } }}
					>
						<Menu />
					</IconButton>
					<Typography variant="h6" noWrap component="div">
						Real Estate Management
					</Typography>
				</Toolbar>
			</AppBar>
			<Box
				component="nav"
				sx={{ width: { sm: drawerWidth }, flexShrink: { sm: 0 } }}
			>
				<Drawer
					variant="temporary"
					open={mobileOpen}
					onClose={handleDrawerToggle}
					ModalProps={{ keepMounted: true }}
					sx={{
						display: { xs: "block", sm: "none" },
						"& .MuiDrawer-paper": {
							boxSizing: "border-box",
							width: drawerWidth,
						},
					}}
				>
					{drawer}
				</Drawer>
				<Drawer
					variant="permanent"
					sx={{
						display: { xs: "none", sm: "block" },
						"& .MuiDrawer-paper": {
							boxSizing: "border-box",
							width: drawerWidth,
						},
					}}
					open
				>
					{drawer}
				</Drawer>
			</Box>
			<Box
				component="main"
				sx={{
					flexGrow: 1,
					p: 3,
					width: { sm: `calc(100% - ${drawerWidth}px)` },
				}}
			>
				<Toolbar />
				{children}
			</Box>
		</Box>
	);
}
