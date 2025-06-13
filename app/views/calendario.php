<?php
class Calendario {
    private $eventos = [];

    public function agregarEvento($evento) {
        $this->eventos[] = $evento;
    }

    public function obtenerEventosPorFecha($fecha) {
        return array_filter($this->eventos, function($evento) use ($fecha) {
            return $evento->getFecha() == $fecha;
        });
    }

    public function generarCalendario($mes, $año) {
        $diasEnMes = date('t', mktime(0, 0, 0, $mes, 1, $año));
        $primerDia = date('N', mktime(0, 0, 0, $mes, 1, $año));
        
        $html = '<table class="calendar-table">';
        $html .= '<tr><th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th><th>Dom</th></tr>';
        
        $html .= '<tr>';
        // Días vacíos al inicio
        for ($i = 1; $i < $primerDia; $i++) {
            $html .= '<td class="empty-day"></td>';
        }
        
        // Días del mes
        for ($dia = 1; $dia <= $diasEnMes; $dia++) {
            $fechaCompleta = "$año-$mes-" . str_pad($dia, 2, '0', STR_PAD_LEFT);
            $eventosDia = $this->obtenerEventosPorFecha($fechaCompleta);
            $tieneEventos = count($eventosDia) > 0 ? 'has-events' : '';
            
            $html .= '<td class="day-cell '.$tieneEventos.'">';
            $html .= '<button class="day-button" onclick="mostrarEventos(\''.$fechaCompleta.'\')">';
            $html .= $dia;
            $html .= '</button>';
            $html .= '</td>';
            
            // Nueva fila cada 7 días
            if (($dia + $primerDia - 1) % 7 == 0 && $dia != $diasEnMes) {
                $html .= '</tr><tr>';
            }
        }
        
        // Días vacíos al final
        $diasRestantes = 7 - (($diasEnMes + $primerDia - 1) % 7);
        if ($diasRestantes < 7) {
            for ($i = 0; $i < $diasRestantes; $i++) {
                $html .= '<td class="empty-day"></td>';
            }
        }
        
        $html .= '</tr></table>';
        return $html;
    }
}
?>