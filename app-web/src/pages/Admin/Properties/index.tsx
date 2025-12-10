import { useState, useEffect } from "preact/hooks";
import {
	Typography,
	Paper,
	Table,
	TableBody,
	TableCell,
	TableContainer,
	TableHead,
	TableRow,
	Button,
	Dialog,
	DialogTitle,
	DialogContent,
	DialogActions,
	TextField,
	Box,
	IconButton,
	Fab,
} from "@mui/material";
import { Edit, Delete, Add } from "@mui/icons-material";

interface Property {
	id: number;
	title: string;
	address: string;
	price: number;
	area: number;
	type: string;
	status: string;
}

export default function Properties() {
	const [properties, setProperties] = useState<Property[]>([]);
	const [open, setOpen] = useState(false);
	const [editingProperty, setEditingProperty] = useState<Property | null>(null);
	const [formData, setFormData] = useState({
		title: "",
		address: "",
		price: 0,
		area: 0,
		type: "",
		status: "",
	});

	useEffect(() => {
		// Load properties - mock data
		setProperties([
			{
				id: 1,
				title: "Modern Apartment",
				address: "123 Main St",
				price: 250000,
				area: 90,
				type: "Apartment",
				status: "Available",
			},
			{
				id: 2,
				title: "Family House",
				address: "456 Oak Ave",
				price: 350000,
				area: 90,
				type: "House",
				status: "Sold",
			},
		]);
	}, []);

	const handleAdd = () => {
		setEditingProperty(null);
		setFormData({
			title: "",
			address: "",
			price: 0,
			type: "",
			area: 0,
			status: "",
		});
		setOpen(true);
	};

	const handleEdit = (property: Property) => {
		setEditingProperty(property);
		setFormData(property);
		setOpen(true);
	};

	const handleSave = () => {
		if (editingProperty) {
			setProperties((prev) =>
				prev.map((p) =>
					p.id === editingProperty.id
						? { ...formData, id: editingProperty.id }
						: p,
				),
			);
		} else {
			const newProperty = { ...formData, id: Date.now() };
			setProperties((prev) => [...prev, newProperty]);
		}
		setOpen(false);
	};

	const handleDelete = (id: number) => {
		setProperties((prev) => prev.filter((p) => p.id !== id));
	};

	return (
		<Box>
			<Typography variant="h4" gutterBottom>
				Propiedades
			</Typography>

			<TableContainer component={Paper}>
				<Table>
					<TableHead>
						<TableRow>
							<TableCell>Propiedad</TableCell>
							<TableCell>Direccion</TableCell>
							<TableCell>Precio</TableCell>
							<TableCell>Tipo</TableCell>
							<TableCell>Estado</TableCell>
							<TableCell>Acciones</TableCell>
						</TableRow>
					</TableHead>
					<TableBody>
						{properties.map((property) => (
							<TableRow key={property.id}>
								<TableCell>{property.title}</TableCell>
								<TableCell>{property.address}</TableCell>
								<TableCell>${property.price.toLocaleString()}</TableCell>
								<TableCell>{property.type}</TableCell>
								<TableCell>{property.status}</TableCell>
								<TableCell>
									<IconButton onClick={() => handleEdit(property)}>
										<Edit />
									</IconButton>
									<IconButton onClick={() => handleDelete(property.id)}>
										<Delete />
									</IconButton>
								</TableCell>
							</TableRow>
						))}
					</TableBody>
				</Table>
			</TableContainer>

			<Fab
				color="primary"
				aria-label="add"
				sx={{ position: "fixed", bottom: 16, right: 16 }}
				onClick={handleAdd}
			>
				<Add />
			</Fab>

			<Dialog
				open={open}
				onClose={() => setOpen(false)}
				maxWidth="sm"
				fullWidth
			>
				<DialogTitle>
					{editingProperty ? "Edit Property" : "Add Property"}
				</DialogTitle>
				<DialogContent>
					<TextField
						fullWidth
						margin="normal"
						label="Title"
						value={formData.title}
						onChange={(e) =>
							setFormData((prev) => ({
								...prev,
								title: (e.target as HTMLInputElement).value,
							}))
						}
					/>
					<TextField
						fullWidth
						margin="normal"
						label="Address"
						value={formData.address}
						onChange={(e) =>
							setFormData((prev) => ({
								...prev,
								address: (e.target as HTMLInputElement).value,
							}))
						}
					/>
					<TextField
						fullWidth
						margin="normal"
						label="Price"
						type="number"
						value={formData.price}
						onChange={(e) =>
							setFormData((prev) => ({
								...prev,
								price: Number((e.target as HTMLInputElement).value),
							}))
						}
					/>
					<TextField
						fullWidth
						margin="normal"
						label="Type"
						value={formData.type}
						onChange={(e) =>
							setFormData((prev) => ({
								...prev,
								type: (e.target as HTMLInputElement).value,
							}))
						}
					/>
					<TextField
						fullWidth
						margin="normal"
						label="Status"
						value={formData.status}
						onChange={(e) =>
							setFormData((prev) => ({
								...prev,
								status: (e.target as HTMLInputElement).value,
							}))
						}
					/>
				</DialogContent>
				<DialogActions>
					<Button onClick={() => setOpen(false)}>Cancel</Button>
					<Button onClick={handleSave} variant="contained">
						Save
					</Button>
				</DialogActions>
			</Dialog>
		</Box>
	);
}
