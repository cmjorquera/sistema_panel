import { createFileRoute } from "@tanstack/react-router";
import { Save, ShieldCheck } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Switch } from "@/components/ui/switch";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { permisosMenus } from "@/lib/seduc-data";

export const Route = createFileRoute("/_app/permisos")({
  head: () => ({ meta: [{ title: "Permisos — SEDUC Panel" }] }),
  component: PermisosPage,
});

function PermisosPage() {
  return (
    <div className="space-y-6">
      <header className="flex items-start justify-between flex-wrap gap-3">
        <div>
          <h1 className="text-2xl font-semibold">Sistema de permisos</h1>
          <p className="text-sm text-muted-foreground">
            Configura accesos por menú y submenú según el perfil.
          </p>
        </div>
        <div className="flex gap-2">
          <Select defaultValue="admin">
            <SelectTrigger className="w-[220px]">
              <SelectValue />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="admin">Perfil: Administrador</SelectItem>
              <SelectItem value="coord">Perfil: Coordinador</SelectItem>
              <SelectItem value="docente">Perfil: Docente</SelectItem>
              <SelectItem value="soporte">Perfil: Soporte TI</SelectItem>
            </SelectContent>
          </Select>
          <Button className="bg-seduc-blue hover:bg-seduc-blue/90">
            <Save className="h-4 w-4 mr-2" /> Guardar cambios
          </Button>
        </div>
      </header>

      <div className="grid gap-4 lg:grid-cols-3">
        {permisosMenus.map((g) => (
          <Card key={g.grupo} className="shadow-card">
            <CardHeader>
              <div className="flex items-center gap-2">
                <ShieldCheck className="h-4 w-4 text-seduc-blue" />
                <CardTitle className="text-base">{g.grupo}</CardTitle>
              </div>
              <CardDescription>Permisos de menú</CardDescription>
            </CardHeader>
            <CardContent className="space-y-3">
              {g.items.map((item) => (
                <div key={item.nombre} className="rounded-md border border-border p-3">
                  <p className="text-sm font-medium mb-3">{item.nombre}</p>
                  <div className="grid grid-cols-2 gap-2 text-xs">
                    {(["ver", "crear", "editar", "eliminar"] as const).map((k) => (
                      <label
                        key={k}
                        className="flex items-center justify-between rounded bg-muted/50 px-2.5 py-1.5"
                      >
                        <span className="capitalize text-muted-foreground">{k}</span>
                        <Switch defaultChecked={item[k]} />
                      </label>
                    ))}
                  </div>
                </div>
              ))}
            </CardContent>
          </Card>
        ))}
      </div>
    </div>
  );
}
