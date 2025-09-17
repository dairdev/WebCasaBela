import { Typography, Container, Button, Box } from "@mui/material";
import { route } from "preact-router";

export default function NotFound() {
	return (
		<Container maxWidth="sm">
			<Box
				sx={{
					display: "flex",
					flexDirection: "column",
					alignItems: "center",
					justifyContent: "center",
					minHeight: "50vh",
					textAlign: "center",
				}}
			>
				<Typography variant="h1" component="h1" gutterBottom>
					404
				</Typography>
				<Typography variant="h5" component="h2" gutterBottom>
					Page Not Found
				</Typography>
				<Typography variant="body1" gutterBottom>
					The page you're looking for doesn't exist.
				</Typography>
				<Button variant="contained" onClick={() => route("/")} sx={{ mt: 2 }}>
					Go Home
				</Button>
			</Box>
		</Container>
	);
}
