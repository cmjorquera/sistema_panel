import { createFileRoute } from "@tanstack/react-router";
import { CheckCircle2, AlertTriangle, Info, XCircle } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Switch } from "@/components/ui/switch";
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { StatusBadge } from "@/components/seduc/StatusBadge";

export const Route = createFileRoute("/_app/componentes")({
  head: () => ({ meta: [{ title: "Componentes — SEDUC Panel" }] }),
  component: ComponentesPage,
});

function Section({ title, children }: { title: string; children: React.ReactNode }) {
  return (
    <Card className="shadow-card">
      <CardHeader>
        <CardTitle className="text-base">{title}</CardTitle>
      </CardHeader>
      <CardContent>{children}</CardContent>
    </Card>
  );
}

function ComponentesPage() {
  return (
    <div className="space-y-6">
      <header>
        <h1 className="text-2xl font-semibold">Componentes reutilizables</h1>
        <p className="text-sm text-muted-foreground">
          Biblioteca visual del Panel Central — referencia para integración en PHP.
        </p>
      </header>

      <Section title="Botones">
        <div className="flex flex-wrap gap-3">
          <Button className="bg-seduc-blue hover:bg-seduc-blue/90">Primario</Button>
          <Button variant="secondary">Secundario</Button>
          <Button className="bg-success hover:bg-success/90 text-success-foreground">
            Éxito
          </Button>
          <Button className="bg-warning hover:bg-warning/90 text-warning-foreground">
            Advertencia
          </Button>
          <Button variant="destructive">Peligro</Button>
          <Button variant="outline">Outline</Button>
          <Button variant="ghost">Ghost</Button>
        </div>
      </Section>

      <Section title="Badges y estados">
        <div className="flex flex-wrap gap-3">
          <Badge>Default</Badge>
          <Badge variant="secondary">Secundario</Badge>
          <Badge variant="destructive">Peligro</Badge>
          <Badge variant="outline">Outline</Badge>
          <StatusBadge status="activo" />
          <StatusBadge status="inactivo" />
          <StatusBadge status="pendiente" />
          <StatusBadge status="confirmado" />
          <StatusBadge status="realizado" />
          <StatusBadge status="cancelado" />
          <StatusBadge status="bloqueado" />
        </div>
      </Section>

      <Section title="Alertas">
        <div className="grid gap-3 md:grid-cols-2">
          <Alert className="border-seduc-blue/30 bg-seduc-blue/5">
            <Info className="h-4 w-4 text-seduc-blue" />
            <AlertTitle>Información</AlertTitle>
            <AlertDescription>
              El respaldo automático se ejecutará a las 23:00 hrs.
            </AlertDescription>
          </Alert>
          <Alert className="border-success/30 bg-success/5">
            <CheckCircle2 className="h-4 w-4 text-success" />
            <AlertTitle>Operación exitosa</AlertTitle>
            <AlertDescription>Los cambios fueron guardados correctamente.</AlertDescription>
          </Alert>
          <Alert className="border-warning/30 bg-warning/5">
            <AlertTriangle className="h-4 w-4 text-warning-foreground" />
            <AlertTitle>Atención</AlertTitle>
            <AlertDescription>Existen 3 usuarios sin perfil asignado.</AlertDescription>
          </Alert>
          <Alert variant="destructive">
            <XCircle className="h-4 w-4" />
            <AlertTitle>Error</AlertTitle>
            <AlertDescription>No fue posible conectar con el módulo SIGE.</AlertDescription>
          </Alert>
        </div>
      </Section>

      <Section title="Formulario">
        <div className="grid gap-4 md:grid-cols-2 max-w-3xl">
          <div className="space-y-2">
            <Label>Nombre</Label>
            <Input placeholder="Nombre completo" />
          </div>
          <div className="space-y-2">
            <Label>Correo institucional</Label>
            <Input placeholder="usuario@seduc.cl" />
          </div>
          <div className="md:col-span-2 space-y-2">
            <Label>Observaciones</Label>
            <Textarea placeholder="Comentarios..." rows={3} />
          </div>
          <div className="md:col-span-2 flex items-center justify-between rounded-md border border-border p-3">
            <div>
              <p className="text-sm font-medium">Notificaciones por correo</p>
              <p className="text-xs text-muted-foreground">
                Recibir avisos institucionales relevantes.
              </p>
            </div>
            <Switch defaultChecked />
          </div>
        </div>
      </Section>

      <Section title="Modal y Tooltip">
        <div className="flex gap-3">
          <Dialog>
            <DialogTrigger asChild>
              <Button className="bg-seduc-blue hover:bg-seduc-blue/90">Abrir modal</Button>
            </DialogTrigger>
            <DialogContent>
              <DialogHeader>
                <DialogTitle>Confirmar acción</DialogTitle>
                <DialogDescription>
                  ¿Estás seguro de aplicar los cambios al perfil seleccionado?
                </DialogDescription>
              </DialogHeader>
              <DialogFooter>
                <Button variant="outline">Cancelar</Button>
                <Button className="bg-seduc-blue hover:bg-seduc-blue/90">Confirmar</Button>
              </DialogFooter>
            </DialogContent>
          </Dialog>

          <TooltipProvider>
            <Tooltip>
              <TooltipTrigger asChild>
                <Button variant="outline">Mostrar tooltip</Button>
              </TooltipTrigger>
              <TooltipContent>Ayuda institucional SEDUC</TooltipContent>
            </Tooltip>
          </TooltipProvider>
        </div>
      </Section>
    </div>
  );
}
