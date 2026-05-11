import { createFileRoute } from "@tanstack/react-router";
import { useState } from "react";
import { Plus, Search, Eye, Pencil, Trash2 } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Card, CardContent } from "@/components/ui/card";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { Label } from "@/components/ui/label";
import { Switch } from "@/components/ui/switch";
import { StatusBadge } from "@/components/seduc/StatusBadge";
import { modulos } from "@/lib/seduc-data";

export const Route = createFileRoute("/_app/modulos")({
  head: () => ({ meta: [{ title: "Módulos — SEDUC Panel" }] }),
  component: ModulosPage,
});

function ModulosPage() {
  const [q, setQ] = useState("");
  const filtered = modulos.filter(
    (m) =>
      m.nombre.toLowerCase().includes(q.toLowerCase()) ||
      m.slug.toLowerCase().includes(q.toLowerCase()),
  );

  return (
    <div className="space-y-6">
      <header className="flex items-start justify-between flex-wrap gap-3">
        <div>
          <h1 className="text-2xl font-semibold">Gestión de módulos</h1>
          <p className="text-sm text-muted-foreground">
            Habilita o deshabilita módulos del sistema institucional.
          </p>
        </div>
        <ModuloDialog />
      </header>

      <Card className="shadow-card">
        <CardContent className="p-0">
          <div className="flex items-center justify-between gap-3 p-4 border-b border-border">
            <div className="relative max-w-sm w-full">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input
                placeholder="Buscar módulo..."
                className="pl-9"
                value={q}
                onChange={(e) => setQ(e.target.value)}
              />
            </div>
            <p className="text-xs text-muted-foreground">{filtered.length} resultados</p>
          </div>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nombre</TableHead>
                <TableHead>Identificador</TableHead>
                <TableHead>Estado</TableHead>
                <TableHead>Actualizado</TableHead>
                <TableHead className="text-right">Acciones</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filtered.map((m) => (
                <TableRow key={m.id}>
                  <TableCell className="font-medium">{m.nombre}</TableCell>
                  <TableCell className="font-mono text-xs text-muted-foreground">
                    {m.slug}
                  </TableCell>
                  <TableCell>
                    <StatusBadge status={m.estado} />
                  </TableCell>
                  <TableCell className="text-muted-foreground">{m.actualizado}</TableCell>
                  <TableCell className="text-right">
                    <div className="inline-flex gap-1">
                      <Button variant="ghost" size="icon" className="h-8 w-8" title="Ver">
                        <Eye className="h-4 w-4" />
                      </Button>
                      <Button variant="ghost" size="icon" className="h-8 w-8" title="Editar">
                        <Pencil className="h-4 w-4" />
                      </Button>
                      <Button
                        variant="ghost"
                        size="icon"
                        className="h-8 w-8 text-destructive hover:text-destructive"
                        title="Eliminar"
                      >
                        <Trash2 className="h-4 w-4" />
                      </Button>
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
      </Card>
    </div>
  );
}

function ModuloDialog() {
  return (
    <Dialog>
      <DialogTrigger asChild>
        <Button className="bg-seduc-blue hover:bg-seduc-blue/90">
          <Plus className="h-4 w-4 mr-2" /> Agregar módulo
        </Button>
      </DialogTrigger>
      <DialogContent>
        <DialogHeader>
          <DialogTitle>Nuevo módulo</DialogTitle>
          <DialogDescription>
            Define los datos del módulo que se integrará al panel central.
          </DialogDescription>
        </DialogHeader>
        <div className="space-y-4 py-2">
          <div className="space-y-2">
            <Label htmlFor="nombre">Nombre del módulo</Label>
            <Input id="nombre" placeholder="Ej: Gestión académica" />
          </div>
          <div className="space-y-2">
            <Label htmlFor="slug">Identificador</Label>
            <Input id="slug" placeholder="academico" />
          </div>
          <div className="flex items-center justify-between rounded-md border border-border p-3">
            <div>
              <p className="text-sm font-medium">Activo al crear</p>
              <p className="text-xs text-muted-foreground">
                Disponible inmediatamente en el menú principal.
              </p>
            </div>
            <Switch defaultChecked />
          </div>
        </div>
        <DialogFooter>
          <Button variant="outline">Cancelar</Button>
          <Button className="bg-seduc-blue hover:bg-seduc-blue/90">Guardar módulo</Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  );
}
