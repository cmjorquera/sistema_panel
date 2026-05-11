import { createFileRoute } from "@tanstack/react-router";
import { Plus, MapPin, Users, Boxes, CalendarDays, MoreVertical } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { StatusBadge } from "@/components/seduc/StatusBadge";
import { colegios } from "@/lib/seduc-data";

export const Route = createFileRoute("/_app/colegios")({
  head: () => ({ meta: [{ title: "Colegios — SEDUC Panel" }] }),
  component: ColegiosPage,
});

function ColegiosPage() {
  return (
    <div className="space-y-6">
      <header className="flex items-start justify-between flex-wrap gap-3">
        <div>
          <h1 className="text-2xl font-semibold">Colegios</h1>
          <p className="text-sm text-muted-foreground">
            Establecimientos educacionales bajo dependencia SEDUC.
          </p>
        </div>
        <Button className="bg-seduc-blue hover:bg-seduc-blue/90">
          <Plus className="h-4 w-4 mr-2" /> Registrar colegio
        </Button>
      </header>

      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {colegios.map((c) => (
          <Card key={c.id} className="shadow-card hover:shadow-elevated transition-shadow">
            <CardContent className="p-5">
              <div className="flex items-start justify-between">
                <div className="flex items-center gap-3 min-w-0">
                  <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-md bg-seduc-blue/10 text-seduc-blue font-semibold">
                    {c.nombre
                      .split(" ")
                      .filter((w) => /^[A-Z]/.test(w))
                      .slice(0, 2)
                      .map((w) => w[0])
                      .join("")}
                  </div>
                  <div className="min-w-0">
                    <h3 className="font-semibold truncate">{c.nombre}</h3>
                    <p className="text-xs text-muted-foreground flex items-center gap-1">
                      <MapPin className="h-3 w-3" /> {c.comuna} · RBD {c.rbd}
                    </p>
                  </div>
                </div>
                <DropdownMenu>
                  <DropdownMenuTrigger asChild>
                    <Button variant="ghost" size="icon" className="h-8 w-8">
                      <MoreVertical className="h-4 w-4" />
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent align="end">
                    <DropdownMenuItem>Ver detalle</DropdownMenuItem>
                    <DropdownMenuItem>Editar</DropdownMenuItem>
                    <DropdownMenuItem>Asignar usuarios</DropdownMenuItem>
                    <DropdownMenuItem className="text-destructive">Desactivar</DropdownMenuItem>
                  </DropdownMenuContent>
                </DropdownMenu>
              </div>

              <div className="mt-4">
                <StatusBadge status={c.estado} />
              </div>

              <div className="mt-4 grid grid-cols-3 gap-2 border-t border-border pt-4">
                {[
                  { icon: Users, label: "Usuarios", value: c.usuarios },
                  { icon: Boxes, label: "Módulos", value: c.modulos },
                  { icon: CalendarDays, label: "Eventos", value: c.eventos },
                ].map((m) => {
                  const Icon = m.icon;
                  return (
                    <div key={m.label} className="text-center">
                      <Icon className="h-4 w-4 mx-auto text-muted-foreground" />
                      <p className="mt-1 text-base font-semibold">{m.value}</p>
                      <p className="text-[11px] text-muted-foreground">{m.label}</p>
                    </div>
                  );
                })}
              </div>
            </CardContent>
          </Card>
        ))}
      </div>
    </div>
  );
}
