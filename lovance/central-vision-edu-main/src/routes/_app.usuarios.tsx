import { createFileRoute } from "@tanstack/react-router";
import { useState } from "react";
import { Plus, Search, Pencil, ShieldCheck } from "lucide-react";
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
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { Switch } from "@/components/ui/switch";
import { StatusBadge } from "@/components/seduc/StatusBadge";
import { usuarios } from "@/lib/seduc-data";

export const Route = createFileRoute("/_app/usuarios")({
  head: () => ({ meta: [{ title: "Usuarios — SEDUC Panel" }] }),
  component: UsuariosPage,
});

function UsuariosPage() {
  const [q, setQ] = useState("");
  const filtered = usuarios.filter((u) =>
    `${u.nombre} ${u.correo} ${u.colegio}`.toLowerCase().includes(q.toLowerCase()),
  );

  return (
    <div className="space-y-6">
      <header className="flex items-start justify-between flex-wrap gap-3">
        <div>
          <h1 className="text-2xl font-semibold">Gestión de usuarios</h1>
          <p className="text-sm text-muted-foreground">
            Administra accesos, perfiles y colegios asociados.
          </p>
        </div>
        <Button className="bg-seduc-blue hover:bg-seduc-blue/90">
          <Plus className="h-4 w-4 mr-2" /> Nuevo usuario
        </Button>
      </header>

      <Card className="shadow-card">
        <CardContent className="p-0">
          <div className="flex items-center justify-between gap-3 p-4 border-b border-border">
            <div className="relative max-w-sm w-full">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input
                placeholder="Buscar por nombre, correo o colegio..."
                className="pl-9"
                value={q}
                onChange={(e) => setQ(e.target.value)}
              />
            </div>
            <p className="text-xs text-muted-foreground">{filtered.length} usuarios</p>
          </div>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Usuario</TableHead>
                <TableHead>RUT</TableHead>
                <TableHead>Tipo</TableHead>
                <TableHead>Colegio asociado</TableHead>
                <TableHead>Estado</TableHead>
                <TableHead className="text-right">Acciones</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filtered.map((u) => (
                <TableRow key={u.id}>
                  <TableCell>
                    <div className="flex items-center gap-3">
                      <Avatar className="h-8 w-8">
                        <AvatarFallback className="bg-seduc-blue/10 text-seduc-blue text-xs">
                          {u.nombre
                            .split(" ")
                            .slice(0, 2)
                            .map((n) => n[0])
                            .join("")}
                        </AvatarFallback>
                      </Avatar>
                      <div className="min-w-0">
                        <p className="text-sm font-medium truncate">{u.nombre}</p>
                        <p className="text-xs text-muted-foreground truncate">{u.correo}</p>
                      </div>
                    </div>
                  </TableCell>
                  <TableCell className="font-mono text-xs">{u.rut}</TableCell>
                  <TableCell>
                    <span className="text-xs px-2 py-1 rounded-md bg-muted text-foreground/80">
                      {u.tipo}
                    </span>
                  </TableCell>
                  <TableCell className="text-sm text-muted-foreground">{u.colegio}</TableCell>
                  <TableCell>
                    <StatusBadge status={u.estado} />
                  </TableCell>
                  <TableCell className="text-right">
                    <div className="inline-flex gap-1">
                      <PermisosDialog nombre={u.nombre} />
                      <Button variant="ghost" size="icon" className="h-8 w-8">
                        <Pencil className="h-4 w-4" />
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

function PermisosDialog({ nombre }: { nombre: string }) {
  const items = ["Dashboard", "Usuarios", "Colegios", "Módulos", "Eventos", "Reportes"];
  return (
    <Dialog>
      <DialogTrigger asChild>
        <Button variant="ghost" size="icon" className="h-8 w-8" title="Permisos">
          <ShieldCheck className="h-4 w-4" />
        </Button>
      </DialogTrigger>
      <DialogContent>
        <DialogHeader>
          <DialogTitle>Permisos de {nombre}</DialogTitle>
          <DialogDescription>Activa los menús a los que tendrá acceso.</DialogDescription>
        </DialogHeader>
        <div className="space-y-2 py-2">
          {items.map((it, i) => (
            <div
              key={it}
              className="flex items-center justify-between rounded-md border border-border px-3 py-2.5"
            >
              <span className="text-sm">{it}</span>
              <Switch defaultChecked={i % 3 !== 2} />
            </div>
          ))}
        </div>
        <DialogFooter>
          <Button variant="outline">Cancelar</Button>
          <Button className="bg-seduc-blue hover:bg-seduc-blue/90">Guardar permisos</Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  );
}
